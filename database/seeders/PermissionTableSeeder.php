<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Permissions
        $permissions = [
            [
                'title' => 'Manage Clients',
                'name' => 'clients_access',
            ],
            [
                'title' => 'List Clients',
                'name' => 'clients_list',
            ],
            [
                'title' => 'Create Clients',
                'name' => 'clients_create',
            ],
            [
                'title' => 'Edit Clients',
                'name' => 'clients_edit',
            ],
            [
                'title' => 'Read Clients',
                'name' => 'clients_show',
            ],
            [
                'title' => 'Delete Clients',
                'name' => 'clients_delete',
            ],
            [
                'title' => 'Manage Providers',
                'name' => 'providers_access',
            ],
            [
                'title' => 'List Providers',
                'name' => 'providers_list',
            ],
            [
                'title' => 'Create Providers',
                'name' => 'providers_create',
            ],
            [
                'title' => 'Edit Providers',
                'name' => 'providers_edit',
            ],
            [
                'title' => 'Read Providers',
                'name' => 'providers_show',
            ],
            [
                'title' => 'Delete Providers',
                'name' => 'providers_delete',
            ],
            [
                'title' => 'Manage Account',
                'name' => 'account_access',
            ],
            [
                'title' => 'List Expenses',
                'name' => 'expense_list',
            ],
            [
                'title' => 'Create Expenses',
                'name' => 'expense_create',
            ],
            [
                'title' => 'Edit Expenses',
                'name' => 'expense_edit',
            ],
            [
                'title' => 'Read Expenses',
                'name' => 'expense_show',
            ],
            [
                'title' => 'Delete Expenses',
                'name' => 'expense_delete',
            ],
            [
                'title' => 'Read Cashier Cash flow',
                'name' => 'order_cash_flow_show',
            ],
            [
                'title' => 'Read Cash flow',
                'name' => 'cash_flow_show',
            ],
            [
                'title' => 'List Compte',
                'name' => 'compte_list',
            ],
            [
                'title' => 'Create Compte',
                'name' => 'compte_create',
            ],
            [
                'title' => 'Edit Compte',
                'name' => 'compte_edit',
            ],
            [
                'title' => 'Read Compte',
                'name' => 'compte_show',
            ],
            [
                'title' => 'Delete Compte',
                'name' => 'compte_delete',
            ],
            [
                'title' => 'Manage Orders',
                'name' => 'orders_access',
            ],
            [
                'title' => 'Create Orders',
                'name' => 'orders_create',
            ],
            [
                'title' => 'Edit Orders',
                'name' => 'orders_edit',
            ],
            [
                'title' => 'Read Orders',
                'name' => 'orders_show',
            ],
            [
                'title' => 'Delete Orders',
                'name' => 'orders_delete',
            ],
            [
                'title' => 'Manage Users',
                'name' => 'users_access',
            ],
            [
                'title' => 'List Users',
                'name' => 'users_list',
            ],
            [
                'title' => 'Create Users',
                'name' => 'users_create',
            ],
            [
                'title' => 'Edit Users',
                'name' => 'users_edit',
            ],
            [
                'title' => 'Read Users',
                'name' => 'users_show',
            ],
            [
                'title' => 'Delete Users',
                'name' => 'users_delete',
            ],
            [
                'title' => 'Manage Profile',
                'name' => 'profile_access',
            ],
            [
                'title' => 'Manage Products',
                'name' => 'products_access',
            ],
            [
                'title' => 'Create Products',
                'name' => 'products_create',
            ],
            [
                'title' => 'Edit Products',
                'name' => 'products_edit',
            ],
            [
                'title' => 'Read Products',
                'name' => 'products_show',
            ],
            [
                'title' => 'Delete Products',
                'name' => 'products_delete',
            ],
            [
                'title' => 'Manage Categories',
                'name' => 'categories_access',
            ],
            [
                'title' => 'Create Categories',
                'name' => 'categories_create',
            ],
            [
                'title' => 'Edit Categories',
                'name' => 'categories_edit',
            ],
            [
                'title' => 'Read Categories',
                'name' => 'categories_show',
            ],
            [
                'title' => 'Delete Categories',
                'name' => 'categories_delete',
            ],
            [
                'title' => 'Manage Roles',
                'name' => 'roles_access',
            ],
            [
                'title' => 'Create Roles',
                'name' => 'roles_create',
            ],
            [
                'title' => 'Edit Roles',
                'name' => 'roles_edit',
            ],
            [
                'title' => 'Read Roles',
                'name' => 'roles_show',
            ],
            [
                'title' => 'Delete Roles',
                'name' => 'roles_delete',
            ],
            [
                'title' => 'Manage Procurements',
                'name' => 'procurement_access',
            ],
            [
                'title' => 'List Procurements',
                'name' => 'procurement_list',
            ],
            [
                'title' => 'Create Procurements',
                'name' => 'procurement_create',
            ],
            [
                'title' => 'Edit Procurements',
                'name' => 'procurement_edit',
            ],
            [
                'title' => 'Read Procurements',
                'name' => 'procurement_show',
            ],
            [
                'title' => 'Delete Procurements',
                'name' => 'procurement_delete',
            ],
            [
                'title' => 'Manage Report',
                'name' => 'report_access',
            ],
            [
                'title' => 'Read Report Sale',
                'name' => 'report_sale',
            ],
            [
                'title' => 'Read Stock Sale',
                'name' => 'stock_sale',
            ],
            [
                'title' => 'Read Product Report',
                'name' => 'product_report',
            ],
            [
                'title' => 'Read Sale Progress',
                'name' => 'sales_progress',
            ],
            [
                'title' => 'Read Profit',
                'name' => 'profit',
            ],
            [
                'title' => 'Read Report Cash Flow',
                'name' => 'cash_flow',
            ],
            [
                'title' => 'Manage Inventory',
                'name' => 'inventory_access',
            ],
            [
                'title' => 'List Inventory Stock',
                'name' => 'inventory_stock',
            ],
            [
                'title' => 'Create Inventory Stock',
                'name' => 'inventory_physic_stock',
            ],
            [
                'title' => 'Validate Inventory Stock',
                'name' => 'update_stock',
            ],
            [
                'title' => 'List Stock HS',
                'name' => 'hs_stock',
            ],
            [
                'title' => 'Create HS Stock',
                'name' => 'hs_physic_stock',
            ],
            [
                'title' => 'Validate HS Stock',
                'name' => 'update_hs_stock',
            ],
            [
                'title' => 'Read Stock',
                'name' => 'stock_show',
            ],
            [
                'title' => 'Ajust Products Report',
                'name' => 'ajust_stock',
            ],
            [
                'title' => 'Manage Param',
                'name' => 'param_access',
            ],
            [
                'title' => 'View Dashboard',
                'name' => 'dashboard_access',
            ],
            [
                'title' => 'Cashier Dashboard',
                'name' => 'cashier_access',
            ],
            [
                'title' => 'Owner Dashboard',
                'name' => 'owners_access',
            ],
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission['name'], 'title' => $permission['title']]);
        }
    }
}
