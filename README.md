# SaasPress
Full-featured multi-tenancy for wordpress, turn any wordpress installation and plugin into a Saas product
This software is still in the early phase of development. Your contributions will be appreciated.
We do not have a community for this software yet but you can request for features and custom development/support by writing me on whatsapp/telegram +79644165577

This software works by creating user specific tables for each user that signup on your wordpress installation (Tenants) so, by using other plugins to moderate their wp-admin dashboard,
you have a Saas platform where each tenant has a completely unique dashboard on the same wordpress installation.
The tables (Plugins) that you want to make unique for each of your tenant can be configured from the plugin settings.
Essentially we are simulating the same wordpress installation but different database for each of your users (Tenants)
SaaSPress Plugin Changelog
Version 1.1
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
Version 1.0
Date: 2024-06-24

Initial Release:

Basic multi-tenant setup with unique content and independent plugin instances for each user.
Strict role management to ensure content isolation.
