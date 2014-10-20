<?php

namespace HtUserRegistrationTest\Controller;

use ZfcUser\Mapper\User;
use Zend\ServiceManager\ServiceManager;
use Zend\EventManager\StaticEventManager;
use Zend\Http\Request;
use Zend\Mvc\Router\Http\RouteMatch;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\SimpleRouteStack;
use Zend\Mvc\Router\Http\Segment;
use HtUserRegistration\Controller\UserRegistrationController;

class UserRegistrationControllerTest extends \PHPUnit_Framework_TestCase
{

    protected $serviceManager;
    protected $request;
    protected $event;
    protected $zfcUserMapper;
    protected $zfcUserEntity;
    protected $moduleOptions;
    protected $userRegistrationService;
    protected $userRegistrationMapper;
    protected $userRegistrationEntity;
    protected $controller;
    protected $verifyEmailRoute = 'verify-email';
    protected $setPasswordRoute = 'set-password';
    protected $userId = 123;
    protected $token = 123;
    protected $redirectRoute = 'test';

    protected function setUp()
    {
        StaticEventManager::resetInstance();

        $this->serviceManager = new ServiceManager();
        $this->request = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'HtUserRegistration'));
        $this->event = new MvcEvent();
        $this->event->setRouteMatch($this->routeMatch);

        $this->zfcUserMapper = $this->getMock('ZfcUser\Mapper\User');
        $this->zfcUserEntity = $this->getMock('ZfcUser\Entity\UserInterface');

        $this->userRegistrationService = $this->getMock('HtUserRegistration\Service\UserRegistrationServiceInterface');
        $this->userRegistrationMapper = $this->getMock('HtUserRegistration\Mapper\UserRegistrationMapperInterface');
        $this->userRegistrationEntity = $this->getMock('HtUserRegistration\Entity\UserRegistrationInterface');

        $this->moduleOptions = $this->getMock('HtUserRegistration\Options\ModuleOptions');
        $this->moduleOptions->expects($this->any())
                ->method('getPostVerificationRoute')
                ->willReturn($this->redirectRoute);

        $routeStack = new SimpleRouteStack;
        $route = new Segment($this->redirectRoute);
        $routeStack->addRoute($this->redirectRoute, $route);
        $this->event->setRouter($routeStack);

        $this->serviceManager->setService('HtUserRegistration\ModuleOptions', $this->moduleOptions);

        $this->controller = new UserRegistrationController($this->userRegistrationService);
        $this->controller->setServiceLocator($this->serviceManager);
        $this->controller->setEvent($this->event);
    }

    public function testVerifyEmailActionWithOutUserId()
    {
        $this->routeMatch->setParam('action', $this->verifyEmailRoute);
        $this->routeMatch->setParam('token', $this->token);

        $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testVerifyEmailActionWithOutToken()
    {
        $this->routeMatch->setParam('action', $this->verifyEmailRoute);
        $this->routeMatch->setParam('userId', $this->userId);

        $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testVerifyEmailActionNoUserFound()
    {
        $this->zfcUserMapper->expects($this->once())
                ->method('findById')
                ->with($this->userId)
                ->willReturn(null);

        $this->serviceManager->setService('zfcuser_user_mapper', $this->zfcUserMapper);

        $this->routeMatch->setParam('action', $this->verifyEmailRoute);
        $this->routeMatch->setParam('userId', $this->userId);
        $this->routeMatch->setParam('token', $this->token);

        $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testVerifyEmailActionEmailNotVerified()
    {
        $this->zfcUserMapper->expects($this->once())
                ->method('findById')
                ->with($this->userId)
                ->willReturn($this->zfcUserEntity);

        $this->serviceManager->setService('zfcuser_user_mapper', $this->zfcUserMapper);

        $this->userRegistrationService->expects($this->once())
                ->method('verifyEmail')
                ->with($this->zfcUserEntity, $this->token)
                ->willReturn(false);

        $this->routeMatch->setParam('action', $this->verifyEmailRoute);
        $this->routeMatch->setParam('userId', $this->userId);
        $this->routeMatch->setParam('token', $this->token);

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);
        $this->assertSame('ht-user-registration/user-registration/verify-email-error.phtml', $result->getTemplate());
    }

    public function testVerifyEmailActionEmailVerified()
    {
        $this->zfcUserMapper->expects($this->once())
                ->method('findById')
                ->with($this->userId)
                ->willReturn($this->zfcUserEntity);

        $this->serviceManager->setService('zfcuser_user_mapper', $this->zfcUserMapper);

        $this->userRegistrationService->expects($this->once())
                ->method('verifyEmail')
                ->with($this->zfcUserEntity, $this->token)
                ->willReturn(true);

        $this->routeMatch->setParam('action', $this->verifyEmailRoute);
        $this->routeMatch->setParam('userId', $this->userId);
        $this->routeMatch->setParam('token', $this->token);

        $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(302, $response->getStatusCode());
    }

    public function testSetPasswordActionWithOutUserId()
    {
        $this->routeMatch->setParam('action', $this->setPasswordRoute);
        $this->routeMatch->setParam('token', $this->token);

        $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testSetPasswordActionWithOutToken()
    {
        $this->routeMatch->setParam('action', $this->setPasswordRoute);
        $this->routeMatch->setParam('userId', $this->userId);

        $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testSetPasswordActionNoUserFound()
    {
        $this->zfcUserMapper->expects($this->once())
                ->method('findById')
                ->with($this->userId)
                ->willReturn(null);

        $this->serviceManager->setService('zfcuser_user_mapper', $this->zfcUserMapper);

        $this->routeMatch->setParam('action', $this->setPasswordRoute);
        $this->routeMatch->setParam('userId', $this->userId);
        $this->routeMatch->setParam('token', $this->token);

        $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testSetPasswordActionNoRecordFound()
    {
        $this->zfcUserMapper->expects($this->once())
                ->method('findById')
                ->with($this->userId)
                ->willReturn($this->zfcUserEntity);

        $this->userRegistrationMapper->expects($this->once())
                ->method('findByUser')
                ->with($this->zfcUserEntity)
                ->willReturn(false);

        $this->serviceManager->setService('zfcuser_user_mapper', $this->zfcUserMapper);
        $this->serviceManager->setService('HtUserRegistration\UserRegistrationMapper', $this->userRegistrationMapper);

        $this->routeMatch->setParam('action', $this->setPasswordRoute);
        $this->routeMatch->setParam('userId', $this->userId);
        $this->routeMatch->setParam('token', $this->token);

        $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testSetPasswordActionInvalidToken()
    {
        $this->zfcUserMapper->expects($this->once())
                ->method('findById')
                ->with($this->userId)
                ->willReturn($this->zfcUserEntity);

        $this->userRegistrationMapper->expects($this->once())
                ->method('findByUser')
                ->with($this->zfcUserEntity)
                ->willReturn($this->userRegistrationEntity);

        $this->userRegistrationService->expects($this->once())
                ->method('isTokenValid')
                ->with($this->zfcUserEntity, $this->token, $this->userRegistrationEntity)
                ->willReturn(false);

        $this->serviceManager->setService('zfcuser_user_mapper', $this->zfcUserMapper);
        $this->serviceManager->setService('HtUserRegistration\UserRegistrationMapper', $this->userRegistrationMapper);

        $this->routeMatch->setParam('action', $this->setPasswordRoute);
        $this->routeMatch->setParam('userId', $this->userId);
        $this->routeMatch->setParam('token', $this->token);

        $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testSetPasswordActionResponded()
    {
        $this->userRegistrationEntity->expects($this->once())
                ->method('isResponded')
                ->willReturn(true);

        $this->zfcUserMapper->expects($this->once())
                ->method('findById')
                ->with($this->userId)
                ->willReturn($this->zfcUserEntity);

        $this->userRegistrationMapper->expects($this->once())
                ->method('findByUser')
                ->with($this->zfcUserEntity)
                ->willReturn($this->userRegistrationEntity);

        $this->userRegistrationService->expects($this->once())
                ->method('isTokenValid')
                ->with($this->zfcUserEntity, $this->token, $this->userRegistrationEntity)
                ->willReturn(true);

        $this->serviceManager->setService('zfcuser_user_mapper', $this->zfcUserMapper);
        $this->serviceManager->setService('HtUserRegistration\UserRegistrationMapper', $this->userRegistrationMapper);

        $this->routeMatch->setParam('action', $this->setPasswordRoute);
        $this->routeMatch->setParam('userId', $this->userId);
        $this->routeMatch->setParam('token', $this->token);

        $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(302, $response->getStatusCode());
    }

    public function testSetPasswordActionPasswordForm()
    {
        $form = $this->getMockBuilder('ZfcUser\Form\ChangePassword')->disableOriginalConstructor()->getMock();

        $this->userRegistrationEntity->expects($this->once())
                ->method('isResponded')
                ->willReturn(false);

        $this->zfcUserMapper->expects($this->once())
                ->method('findById')
                ->with($this->userId)
                ->willReturn($this->zfcUserEntity);

        $this->userRegistrationMapper->expects($this->once())
                ->method('findByUser')
                ->with($this->zfcUserEntity)
                ->willReturn($this->userRegistrationEntity);

        $this->userRegistrationService->expects($this->once())
                ->method('isTokenValid')
                ->with($this->zfcUserEntity, $this->token, $this->userRegistrationEntity)
                ->willReturn(true);

        $this->serviceManager->setService('zfcuser_user_mapper', $this->zfcUserMapper);
        $this->serviceManager->setService('HtUserRegistration\UserRegistrationMapper', $this->userRegistrationMapper);
        $this->serviceManager->setService('HtUserRegistration\SetPasswordForm', $form);

        $this->routeMatch->setParam('action', $this->setPasswordRoute);
        $this->routeMatch->setParam('userId', $this->userId);
        $this->routeMatch->setParam('token', $this->token);

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertInstanceOf('ZfcUser\Entity\UserInterface', $result['user']);
        $this->assertInstanceOf('ZfcUser\Form\ChangePassword', $result['form']);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testSetPasswordActionPasswordFormValid()
    {
        $testArray = array('test' => 123);

        $form = $this->getMockBuilder('ZfcUser\Form\ChangePassword')->disableOriginalConstructor()->getMock();
        $form->expects($this->once())->method('setData');
        $form->expects($this->once())
                ->method('isValid')
                ->willReturn(true);
        $form->expects($this->once())
                ->method('getData')
                ->willReturn($testArray);

        $this->userRegistrationEntity->expects($this->once())
                ->method('isResponded')
                ->willReturn(false);

        $this->zfcUserMapper->expects($this->once())
                ->method('findById')
                ->with($this->userId)
                ->willReturn($this->zfcUserEntity);

        $this->userRegistrationMapper->expects($this->once())
                ->method('findByUser')
                ->with($this->zfcUserEntity)
                ->willReturn($this->userRegistrationEntity);

        $this->userRegistrationService->expects($this->once())
                ->method('isTokenValid')
                ->with($this->zfcUserEntity, $this->token, $this->userRegistrationEntity)
                ->willReturn(true);
        $this->userRegistrationService->expects($this->once())
                ->method('setPassword')
                ->with($testArray, $this->userRegistrationEntity);

        $this->serviceManager->setService('zfcuser_user_mapper', $this->zfcUserMapper);
        $this->serviceManager->setService('HtUserRegistration\UserRegistrationMapper', $this->userRegistrationMapper);
        $this->serviceManager->setService('HtUserRegistration\SetPasswordForm', $form);

        $this->request->setMethod(Request::METHOD_POST);

        $this->routeMatch->setParam('action', $this->setPasswordRoute);
        $this->routeMatch->setParam('userId', $this->userId);
        $this->routeMatch->setParam('token', $this->token);

        $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertEquals(302, $response->getStatusCode());
    }

    public function testSetPasswordActionPasswordFormInvalid()
    {
        $form = $this->getMockBuilder('ZfcUser\Form\ChangePassword')->disableOriginalConstructor()->getMock();
        $form->expects($this->once())->method('setData');
        $form->expects($this->once())
                ->method('isValid')
                ->willReturn(false);

        $this->userRegistrationEntity->expects($this->once())
                ->method('isResponded')
                ->willReturn(false);

        $this->zfcUserMapper->expects($this->once())
                ->method('findById')
                ->with($this->userId)
                ->willReturn($this->zfcUserEntity);

        $this->userRegistrationMapper->expects($this->once())
                ->method('findByUser')
                ->with($this->zfcUserEntity)
                ->willReturn($this->userRegistrationEntity);

        $this->userRegistrationService->expects($this->once())
                ->method('isTokenValid')
                ->with($this->zfcUserEntity, $this->token, $this->userRegistrationEntity)
                ->willReturn(true);

        $this->serviceManager->setService('zfcuser_user_mapper', $this->zfcUserMapper);
        $this->serviceManager->setService('HtUserRegistration\UserRegistrationMapper', $this->userRegistrationMapper);
        $this->serviceManager->setService('HtUserRegistration\SetPasswordForm', $form);

        $this->request->setMethod(Request::METHOD_POST);

        $this->routeMatch->setParam('action', $this->setPasswordRoute);
        $this->routeMatch->setParam('userId', $this->userId);
        $this->routeMatch->setParam('token', $this->token);

        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertInstanceOf('ZfcUser\Entity\UserInterface', $result['user']);
        $this->assertInstanceOf('ZfcUser\Form\ChangePassword', $result['form']);
        $this->assertEquals(200, $response->getStatusCode());
    }

}
