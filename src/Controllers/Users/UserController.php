<?php

namespace SM\Controllers\Users;

use Simple\Core\View;
use Simple\Core\Router;
use Simple\Core\Request;
use Simple\Core\Session;
use Simple\Core\Redirect;
use SM\Helpers\Translate;
use SM\Entities\Users\User;
use SM\Views\User\UserView;
use SM\Repos\Users\UserRepo;
use SM\Repos\Users\IUserRepo;
use SM\Repos\Users\UserGroupRepo;
use SM\Controllers\ErrorController;
use Simple\Core\DataAccess\MySQLAccess;
use SM\Exceptions\AuthorizationException;
use SM\Exceptions\EntityNotFoundException;
use SM\Repos\Users\UserGroupRepoInterface;

class UserController
{
    /**
     * @var \SM\Repos\Users\IUserRepo
     */
    private IUserRepo $usersRepo;

    /**
     * @var \Simple\Core\Request
     */
    private Request $request;

    /**
     * @var \Simple\Core\Router
     */
    private Router $router;

    /**
     * @var \SM\Views\User\UserView
     */
    private UserView $view;

    /**
     * @var \SM\Repos\Users\UsersGroupRepoInterface
     */
    private UserGroupRepoInterface $groupsRepo;

    /**
     * Contructing the object
     * 
     * @param \Simple\Core\Request $request
     * @param \Simple\Core\Router
     */
    public function __construct(Request $request, Router $router)
    {
        if (Session::get('group-name') !== 'admin') {
            throw new AuthorizationException();
        }

        $this->request = $request;
        $this->router = $router;
        $this->view = new UserView();

        $this->usersRepo = new UserRepo(new MySQLAccess());
    }

    /**
     * index fetching the users data then display it
     * @param void
     */
    public function index()
    {
        $users = $this->usersRepo->getAll();
        $translatedUsers = array_map(function ($user) {
            $user = $user->toArray();
            $user['user-group-name'] = Translate::get('group', $user['user-group-name']);
            $user['user-privileges'] = Translate::get('privilege', $user['user-privileges']);
            return $user;
        }, $users);

        $this->view->addToContextData('users', $translatedUsers);
        $this->view->mainView();
    }

    /**
     * Rendering the template
     * 
     * @param array $context
     */
    public function render($context)
    {
        View::render('users/users.twig', $context);
    }

    /**
     * Edit current user
     */
    public function update()
    {
        $user = $this->arrayToUser($this->request->getRequestBody()['post']);
        $result = $this->usersRepo->update($user);
        Redirect::to('/admin/users');
    }

    /**
     * Shows edit form
     */
    public function edit()
    {
        $userId = $this->router->get('id');
        try {
            $user = $this->usersRepo->getById($userId);
        } catch (EntityNotFoundException $er) {
            ErrorController::pageNotFound("user not found", "there is no user with id = '$userId'");
        }
        $this->view->addToContextData('privileges', $this->getPrivileges());
        $this->view->addToContextData('types', $this->getGroups());
        $this->view->showEdit($user);
    }

    /**
     * Get user groups
     * 
     * @return array
     */
    private function getGroups()
    {
        $groupsRepo = $this->groupsRepo = new UserGroupRepo(new MySQLAccess());
        $groups = $groupsRepo->getAll();

        $translatedGroups = array_map(function ($group) {
            $group['group_name'] = Translate::get('group', $group['group_name']);
            return $group;
        }, $groups);

        return $translatedGroups;
    }

    /**
     * Get privileges
     * 
     * @return array
     */
    private function getPrivileges()
    {
        $privileges = ['READ', 'WRITE'];
        $translatedPrivileges = array_map(function ($privilege) {
            $translated = Translate::get('privilege', $privilege);
            return ['key' => $privilege, 'value' => $translated];
        }, $privileges);
        return $translatedPrivileges;
    }

    /**
     * Transform an array to user object
     * 
     * @param array $data
     * @return \SM\Entities\Users\User
     */
    private function arrayToUser(array $data): User
    {
        $user = $this->usersRepo->getById($data['user-id']);
        $user->setUserName($data['user-name']);
        $user->setGroupId($data['group']);
        $user->setPrivileges($data['privileges']);
        $user->setIsActive($data['is-active']);
        return $user;
    }
}
