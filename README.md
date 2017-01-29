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
    + [Controllers](http://symfony.com/doc/current/best_practices/controllers.html)
        + Make your controller extend the FrameworkBundle base controller and use annotations to configure routing, caching and security whenever possible.
        + Don't use the @Template annotation to configure the template used by the controller.
        + Use the ParamConverter trick to automatically query for Doctrine entities when it's simple and convenient.
    + [Templates](http://symfony.com/doc/current/best_practices/templates.html)
        + Use Twig templating format for your templates.
        + Store all your application's templates in app/Resources/views/ directory.
        + Use lowercased snake_case for directory and template names.
        + Define your Twig extensions in the AppBundle/Twig/ directory and configure them using the app/config/services.yml file.
    + [Forms](http://symfony.com/doc/current/best_practices/forms.html)
        + Define your forms as PHP classes.
        + Put the form type classes in the AppBundle\Form namespace, unless you use other custom form classes like data transformers.
        + Add buttons in the templates, not in the form classes or the controllers.
    + [Internationalization](http://symfony.com/doc/current/best_practices/i18n.html)
        + Use the XLIFF format for your translation files.
        + Store the translation files in the app/Resources/translations/ directory.
        + Always use keys for translations instead of content strings.
    + [Security](http://symfony.com/doc/current/best_practices/security.html)
        + Unless you have two legitimately different authentication systems and users (e.g. form login for the main site and a token system for your API only), we recommend having only one firewall entry with the anonymous key enabled.
        + Use the bcrypt encoder for encoding your users' passwords.
        + For protecting broad URL patterns, use access_control.
        + Whenever possible, use the @Security annotation.
        + Check security directly on the security.authorization_checker service whenever you have a more complex situation.
        + For fine-grained restrictions, define a custom security voter.
        + For restricting access to any object by any user via an admin interface, use the Symfony ACL.
    + [Web Assets](http://symfony.com/doc/current/best_practices/web-assets.html)
        + Store your assets in the web/ directory.
        + Use Assetic to compile, combine and minimize web assets, unless you're comfortable with frontend tools like GruntJS.
    + [Tests](http://symfony.com/doc/current/best_practices/tests.html)
        + Define a functional test that at least checks if your application pages are successfully loading.
        + Hardcode the URLs used in the functional tests instead of using the URL generator.
        
2. Behat
    + Launch in an other command tab : `java -jar selenium.jar` to launch the selenium server.