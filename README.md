initializedProject
==================

1. Symfony Best Practices (those can be found [on the official documentation](http://symfony.com/doc/current/best_practices/index.html))

    + [Creating the Project](http://symfony.com/doc/current/best_practices/creating-the-project.html)
        + Use the Symfony Installer to create new Symfony-based projects.
        + Create only one bundle called AppBundle for your application logic.
    + [Configuration](http://symfony.com/doc/current/best_practices/configuration.html)
        + Define the infrastructure-related configuration options in the `app/config/parameters.yml` file.
        + Define all your application's parameters in the `app/config/parameters.yml.dist` file.
        + Define the application behavior related configuration options in the `app/config/config.yml` file.
        + Use constants to define configuration options that rarely change.
        + Don't define a semantic dependency injection configuration for your bundles.
    + [Organizing your business logic](http://symfony.com/doc/current/best_practices/business-logic.html)
        + The name of your application's services should be as short as possible, but unique enough that you can search your project for the service if you ever need to.
        + Use the YAML format to define your own services.
        + Don't define parameters for the classes of your services.
        + Use annotations to define the mapping information of the Doctrine entities.