<?php

namespace SM\Views\User;

use Simple\Core\View;
use SM\Entities\Users\User;

class UserView
{
    private string $editTemplate = 'users/edit-user.twig';

    private string $mainTemplate = 'users/users.twig';

    private string $parentTemplate = 'admin/admin.twig';

    private array $contextData;

    private function render()
    {
    }

    public function __construct(array $data = [])
    {
        $this->contextData = $data;
    }

    public function mainView()
    {
        View::render($this->mainTemplate, $this->contextData);
    }

    public function setContextData(array $data)
    {
        $this->contextData['data'] = $data;
    }

    public function showEdit(User $user)
    {
        $this->contextData['user'] = $user;
        View::render($this->editTemplate, $this->contextData);
    }

    public function addToContextData(string $name, array $data)
    {
        $this->contextData[$name] = $data;
    }
}
