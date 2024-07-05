# SaasPress Beta (0.1)
Full-featured multi-tenancy for wordpress, turn any wordpress installation and plugin into a Saas product
This software is still in the early phase of development. Your contributions will be appreciated.
We do not have a community for this software yet but you can request for features and custom development/support by writing me on whatsapp/telegram +79644165577

This software works by creating user specific tables for each user that signup on your wordpress installation (Tenants) so, by using other plugins to moderate their wp-admin dashboard,
you have a Saas platform where each tenant has a completely unique dashboard on the same wordpress installation.
The tables (Plugins) that you want to make unique for each of your tenant can be configured from the plugin settings.
Essentially we are simulating the same wordpress installation but different database for each of your users (Tenants)


SaaSPress Plugin Changelog

## Version 0.1 (Initital release)

Date: 2024-06-26


New Features:

Admin Settings Page with Submenus:
About Us: Displays a static message about the plugin.
Tenants: Displays a table with columns for User, User ID, Is Tenant (Yes/No), Email, Tenant Tables, and Tenant Database Details.
Configurations:
Tenant DB Tab: Allows admin to manage tenant database settings.
Make Tenants Tab: Allows admin to create new tenants and duplicate selected database tables for them.
Enhancements:

Tenant Management:
Updated TenantManager class to handle tenant creation, table duplication, and prefix switching.
Admin can select database tables to duplicate for each tenant.
Admin can specify whether to use the default WordPress database or additional databases for tenant data.
Bug Fixes:

Initial release of tenant management system, ensuring isolated environments for each user within the same WordPress installation.
Previous Versions
Version 0.1
Date: 2024-06-24

Initial Release:

Basic multi-tenant setup with unique content and independent plugin instances for each user.
Strict role management to ensure content isolation.

## VERSION 0.2 UPDATE IS GOING TO BE PUBLISHED TO THIS REPOSITORY IN BITS FROM TODAY 3/7/2024 - 11/7/2024

# SaasPress - Multi-Tenant WordPress Plugin

SaasPress is a powerful WordPress plugin designed to provide a multi-tenant setup where each user has their own isolated environment within the same WordPress installation. This includes unique content, independent plugin instances, and strict role management. Essentially, it's like running WordPress as a SaaS (Software as a Service) platform with deep role management and content isolation.

## Features (version 0.2 Update)

1. **Multi-Tenant Database Architecture:** Supports multi-tenant architecture by isolating tenant data in separate database tables.
2. **Dynamic Database Connections:** Can dynamically switch between multiple databases based on tenant configuration.
3. **Tenant-Specific Table Prefixes:** Each tenant has a unique table prefix, ensuring no data overlap.
4. **Global Filters Page:** Admin can select which WordPress tables should be duplicated for each tenant.
5. **Tenant Database Settings:** Admin can input multiple database credentials and set limits on the number of tenants per database.
6. **Random Table Prefix Generation:** Ensures that each tenant's table prefix is unique and randomly generated.
7. **User Management:** Admin can select multiple users and make them tenants with appropriate table duplication and prefix generation.
8. **Tenant Registration:** All new user registrations, regardless of role, are automatically made tenants with appropriate database filters and table duplication.
9. **Clean Table Duplication:** When duplicating tables for tenants, the plugin ensures that no existing data is copied; tables are replicated empty.
10. **Tenant Content Isolation:** Ensures that tenants can only read and write to their respective tables, preventing data leaks.
11. **Multiple Database Support:** The plugin can write to and read from any database provided, not just the default WordPress database.
12. **Database Switching Logic:** Implements logic to switch databases based on the number of tenants per database, as configured globally.
13. **Configuration Page User Selection:** The admin can view all users in the WordPress installation, select multiple users, and make them tenants.
14. **Exclusion of Tenant Tables:** In the configuration page, tenant tables are excluded from the list of tables to be duplicated.
15. **Form Validation and User Feedback:** Ensures that forms on the global filters and configuration pages are validated, and users receive appropriate feedback.
16. **Global Settings:** Allows admin to manage global settings such as database details and the number of tenants per database.
17. **Efficient Data Handling:** Optimized for efficient data handling, ensuring smooth operation even with a large number of tenants.
18. **Secure Data Management:** Ensures secure data management practices, preventing unauthorized access to tenant data.
19. **Database Prefix Storage:** Stores tenant-specific database prefixes to manage and track table associations accurately.
20. **Tenant Database Details Display:** Displays tenant-specific database details and prefixes on the tenant management page.
21. **Admin Submenus:** Contains submenus like "About Us" and "Tenants" for better plugin management and information.
22. **Database Connection Testing:** Allows admin to test the connection to provided databases to ensure they are correctly set up.
23. **Tenant Tables Management:** The tenant tables are managed dynamically, ensuring they are clean and isolated per tenant.
24. **Content Isolation Enforcement:** Reinforces content isolation by ensuring tenants interact only with their designated tables.
25. **Detailed Tenants Page:** Provides a detailed tenants page showing tenant information, including database details and prefixes.

## Installation

1. Download the plugin zip file.
2. Navigate to the WordPress admin dashboard.
3. Go to Plugins > Add New > Upload Plugin.
4. Choose the downloaded zip file and click "Install Now".
5. Activate the plugin.

## Usage

1. Navigate to the "SaasPress" menu in the WordPress admin dashboard.
2. Configure global settings, including database details and table duplication preferences.
3. Manage tenants through the "Tenants" submenu.
4. Add or manage database connections and set the number of tenants per database in the global filters page.
5. Use the "Make Tenants" feature to convert existing users to tenants with isolated environments.

## Contributing

We welcome contributions to enhance the SaasPress plugin. Please follow these steps to contribute:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature-branch`).
3. Make your changes and commit them (`git commit -m 'Add new feature'`).
4. Push to the branch (`git push origin feature-branch`).
5. Open a pull request to the main branch.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

## Author

SaasPress is developed and maintained by Angel Cee.

## Support

For support or any questions, please open an issue in this repository or contact us via email at support@tabs101.com or livejossymall@gmail.com
## +79644165577 (whatsapp/telegram)

