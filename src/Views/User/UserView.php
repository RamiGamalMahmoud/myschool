<?php

namespace SM\Views\User;

use Simple\Core\View;
use SM\Entities\Users\User;

class UserView
{
    /**
     * @var string
     */
    private string $editTemplate = 'users/edit-user.twig';

    /**
     * @var string
     */
    private string $mainTemplate = 'users/users.twig';

    /**
     * @var array
     */
    private array $contextData;

    /**
     * Constructor
     * 
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->contextData = $data;
    }

    /**
     * Rndering the main view
     */
    public function mainView()
    {
        View::render($this->mainTemplate, $this->contextData);
    }

    /**
     * Sets the context data
     * 
     * @param array $data
     */
    public function setContextData(array $data)
    {
        $this->contextData['data'] = $data;
    }

    /**
     * Show edit user form
     */
    public function showEdit(User $user)
    {
        $this->contextData['user'] = $user;
        View::render($this->editTemplate, $this->contextData);
    }

    /**
     * Add item to the context data
     * 
     * @param array $name The item name
     * @param array $data The data
     */
    public function addToContextData(string $name, array $data)
    {
        $this->contextData[$name] = $data;
    }
}
