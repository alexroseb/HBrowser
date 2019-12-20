<?php
namespace HBrowser\Api;

use Omeka\Api\Adapter\AdapterInterface;
use Omeka\Api\Adapter\Manager as AdapterManager;
use Omeka\Permissions\Acl;
use Zend\Log\LoggerInterface;
use Zend\I18n\Translator\TranslatorInterface;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\EventManager\Event;

/**
 * API manager service.
 */
class Manager
{
    /**
     * @var AdapterManager
     */
    protected $adapterManager;

    /**
     * @var Acl
     */
    protected $acl;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    public function __construct(AdapterManager $adapterManager, Acl $acl, LoggerInterface $logger,
        TranslatorInterface $translator)
    {
        $this->adapterManager = $adapterManager;
        $this->acl = $acl;
        $this->logger = $logger;
        $this->translator = $translator;
    }

    /**
     * Execute a read API request.
     *
     * @param string $resource
     * @param mixed $id
     * @param array $data
     * @param array $options
     * @return Response
     */
    public function getChildren($resource, $id, array $data = [], array $options = [])
    {
        $request = new Request(Request::CHILDREN, $resource);
        $request->setId($id)
            ->setContent($data)
            ->setOption($options);
        return $this->execute($request);
    }

    /**
     * Execute an API request.
     *
     * @param Request $request
     * @return Response
     */
    public function execute(Request $request)
    {
        $t = $this->translator;

        // Get the adapter.
        try {
            $adapter = $this->adapterManager->get($request->getResource());
        } catch (ServiceNotFoundException $e) {
            throw new Exception\BadRequestException(sprintf(
                $t->translate('The API does not support the "%s" resource.'),
                $request->getResource()
            ));
        }

        // Verify that the current user has general access to this resource.
        if (!$this->acl->userIsAllowed($adapter, $request->getOperation())) {
            throw new Exception\PermissionDeniedException(sprintf(
                $t->translate('Permission denied for the current user to %s the %s resource.'),
                $request->getOperation(),
                $adapter->getResourceId()
            ));
        }

        if ($request->getOption('initialize', true)) {
            $this->initialize($adapter, $request);
        }

        $response = $adapter->getChildren($request);

        // Validate the response and response content.
        if (!$response instanceof Response) {
            throw new Exception\BadResponseException('The API response must implement Omeka\Api\Response');
        }

        $response->setRequest($request);

        $validateContent = function ($value) {
            if (!$value instanceof ResourceInterface) {
                throw new Exception\BadResponseException('API response content must implement Omeka\Api\ResourceInterface.');
            }
        };
        $content = $response->getContent();
        is_array($content) ? array_walk($content, $validateContent) : $validateContent($content);

        if ($request->getOption('finalize', true)) {
            $this->finalize($adapter, $request, $response);
        }

        return $response;
    }

    /**
     * Initialize the request.
     *
     * Triggers the API-pre events.
     *
     * @param AdapterInterface $adapter
     * @param Request $request
     */
    public function initialize(AdapterInterface $adapter, Request $request)
    {
        $eventManager = $adapter->getEventManager();

        $event = new Event(
            'api.execute.pre',
            $adapter,
            ['request' => $request]
        );
        $eventManager->triggerEvent($event);

        // Trigger the api.{operation}.pre event.
        $event = new Event(
            sprintf('api.%s.pre', $request->getOperation()),
            $adapter,
            ['request' => $request]
        );
        $eventManager->triggerEvent($event);
    }

    /**
     * Finalize the request.
     *
     * Triggers API-post events and then transforms response content according
     * to the "responseContent" request option
     *
     * @param AdapterInterface $adapter
     * @param Request $request
     * @param Response $response
     */
    public function finalize(AdapterInterface $adapter, Request $request,
        Response $response
    ) {
        $eventManager = $adapter->getEventManager();

        $event = new Event(
            sprintf('api.%s.post', $request->getOperation()),
            $adapter,
            ['request' => $request, 'response' => $response]
        );
        $eventManager->triggerEvent($event);

        $event = new Event(
            'api.execute.post',
            $adapter,
            ['request' => $request, 'response' => $response]
        );
        $eventManager->triggerEvent($event);

        // Transform the response content.
        $transformContent = function (ResourceInterface $resource) use ($adapter, $request) {
            switch ($request->getOption('responseContent')) {
                case 'resource':
                    return $resource;
                case 'reference':
                    return $adapter->getRepresentation($resource)->getReference();
                case 'representation':
                default:
                    return $adapter->getRepresentation($resource);
            }
        };
        $content = $response->getContent();
        $content = is_array($content)
            ? array_map($transformContent, $content) : $transformContent($content);
        $response->setContent($content);
    }
}