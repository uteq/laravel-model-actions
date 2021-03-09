<?php

return [
    /**
     * The namespace where to find the actions.
     * By default it will look for the actions one folder up
     * than the Actions folder and than the folder name with the name of the class.
     * This will look like this ../Actions/MODEL/*
     *
     * ```
     * App
     * ├── Actions
     * │   └── User
     * │       ├── Create.php
     * │       ├── Update.php
     * │       ├── Destroy.php
     * │       └── AddImage.php
     * └── Models
     * └── User.php
     * ```
     */
    'namespace' => null,

    /**
     * You can overwrite the method used to handle the
     * action. By default this is __invoke.
     */
    'method' => null,
];
