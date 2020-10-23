<?php

namespace SM\Controllers;

interface IPlainController
{
  function index();
  function render(array $viewContext);
  function reRoute();
}
