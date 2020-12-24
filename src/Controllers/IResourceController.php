<?php

namespace SM\Controllers;

interface IResourceController
{
    function create($data);
    function edit($id, $data);
    function index();
    function loadView(array $viewContext);
    function remove($id);
    function show($id = '');
}
