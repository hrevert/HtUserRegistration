<?php
namespace HtUserRegistration\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use HtUserRegistration\Service\UserRegistrationServiceInterface;
use Zend\View\Model\ViewModel;

class UserRegistrationController extends AbstractActionController
{
    /**
     * @var UserRegistrationServiceInterface
     */
    protected $userRegistrationService;

    /**
     * @var \ZfcUser\Mapper\UserInterface
     */
    protected $userMapper;

    /**
     * @var \HtUserRegistration\Mapper\UserRegistrationMapperInterface
     */
    protected $userRegistrationMapper;

    /**
     * Constructor
     * 
     * @param UserRegistrationServiceInterface $userRegistrationService
     */
    public function __construct(UserRegistrationServiceInterface $userRegistrationService)
    {
        $this->userRegistrationService = $userRegistrationService;
    }

    public function verifyEmailAction()
    {
        $userId = $this->params()->fromRoute('userId', null);
        $token = $this->params()->fromRoute('token', null);

        if ($userId === null || $token === null) {
            return $this->notFoundAction();
        }

        $user = $this->getUserMapper()->findById($userId);

        if (!$user) {
            return $this->notFoundAction();
        }

        if ($this->userRegistrationService->verifyEmail($user, $token)) {
            // email verified
            return $this->redirect()->toRoute('zfcuser/login');
        }
        
        // email not verified, probably invalid token
        $vm = new ViewModel();
        $vm->setTemplate('ht-user-registration/user-registration/verify-email-error.phtml');

        return $vm;

    }

    public function setPasswordAction()
    {
        $userId = $this->params()->fromRoute('userId', null);
        $token = $this->params()->fromRoute('token', null);

        if ($userId === null || $token === null) {
            return $this->notFoundAction();
        }

        $user = $this->getUserMapper()->findById($userId);

        if (!$user) {
            return $this->notFoundAction();
        }
        
        $record = $this->getUserRegistrationMapper()->findByUser($user);

        if (!$this->userRegistrationService->isTokenValid($user, $token, $record)) {
            // Invalid Token, Lets surprise the attacker
            return $this->notFoundAction(); 
        }
        
        if ($record->isResponded()) {
            // old link, password is already set by the user
            return $this->redirect()->toRoute('zfcuser/login');
        }
        
        $form = $this->getServiceLocator()->get('HtUserRegistration\SetPasswordForm');

        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {
               $this->userRegistrationService->setPassword($form->getData(), $record);
               return $this->redirect()->toRoute('zfcuser/login');
            }
        }
        
        return array(
            'user' => $user,
            'form' => $form
        );        
    }

    public function getUserMapper()
    {
        if (!$this->userMapper) {
            $this->userMapper = $this->getServiceLocator()->get('zfcuser_user_mapper');
        }

        return $this->userMapper;
    }

    /**
     * Gets userRegistrationMapper
     */
    protected function getUserRegistrationMapper()
    {
        if (!$this->userRegistrationMapper instanceof UserRegistrationMapperInterface) {
            $this->userRegistrationMapper = $this->getServiceLocator()->get('HtUserRegistration\UserRegistrationMapper');
        }

        return $this->userRegistrationMapper;
    }
}
