<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $permissions = [
            'Add patient',
            'View patient',
            'View all patients',
            'View hospital patients',
            'Edit patient',
            'Delete patient',
            'Add hospital',
            'View hospital',
            'Edit hospital',
            'Delete hospital',
            'Add chronic disease',
            'View chronic disease',
            'Edit chronic disease',
            'Delete chronic disease',
            'Add field research',
            'View field research',
            'Add patient report',
            'View patient report',
            'Delete patient report',
            'Add supplies',
            'Edit supplies',
            'Delete supplies',
            'View supplies',
            'View contact forms',
            'Delete contact forms',
            'View activity logs',
            'Access to console page',
            'Add user',
            'Assign users to hospitals',
            'Delete users',
            'Delete admin users'
        ];
        $add_patient = Permission::create(['name' => 'Add patient']);
        $view_patient = Permission::create(['name' => 'View patient']);
        $view_all_patients = Permission::create(['name' => 'View all patients']);
        $view_hospital_patients = Permission::create(['name' => 'View hospital patients']);
        $edit_patient = Permission::create(['name' => 'Edit patient']); 
        $delete_patient = Permission::create(['name' => 'Delete patient']);
        $add_hospital = Permission::create(['name' => 'Add hospital']);
        $view_hospital = Permission::create(['name' => 'View hospital']);

        $edit_hospital = Permission::create(['name' => 'Edit hospital']);
        $delete_hospital = Permission::create(['name' => 'Delete hospital']);
        $add_chronic_disease = Permission::create(['name' => 'Add chronic disease']);
        $view_chronic_disease = Permission::create(['name' => 'View chronic disease']);
        $edit_chronic_disease = Permission::create(['name' => 'Edit chronic disease']);

        $delete_chronic_disease = Permission::create(['name' => 'Delete chronic disease']);
        $add_field_research = Permission::create(['name' => 'Add field research']);
        $view_field_research = Permission::create(['name' => 'View field research']);
        $add_patient_report = Permission::create(['name' => 'Add patient report']);
        $view_patient_report = Permission::create(['name' => 'View patient report']);
        $delete_patient_report = Permission::create(['name' => 'Delete patient report']);
        $add_supplies = Permission::create(['name' => 'Add supplies']);
        $edit_supplies = Permission::create(['name' => 'Edit supplies']);
        $delete_supplies = Permission::create(['name' => 'Delete supplies']);
        $view_supplies = Permission::create(['name' => 'View supplies']);
        $view_contact_forms = Permission::create(['name' => 'View contact forms']);
        $delete_contact_forms = Permission::create(['name' => 'Delete contact forms']);
        $view_activity_logs = Permission::create(['name' => 'View activity logs']);
        $access_to_console_page = Permission::create(['name' => 'Access to console page']);
        $add_user = Permission::create(['name' => 'Add user']);
        $assign_users_to_hospitals = Permission::create(['name' => 'Assign users to hospitals']);
        $delete_users = Permission::create(['name' => 'Delete users']);
        $delete_admin_users = Permission::create(['name' => 'Delete admin users']);

        $admin_role = Role::create(['name' => 'admin']);
        $admin_role->givePermissionTo($permissions);
        $coordinator_role = Role::create(['name' => 'coordinator']);
        $coordinator_role->givePermissionTo($add_patient);
        $coordinator_role->givePermissionTo($view_hospital_patients);
        $coordinator_role->givePermissionTo($view_patient);
        $coordinator_role->givePermissionTo($edit_patient);
        $coordinator_role->givePermissionTo($add_field_research);
        $coordinator_role->givePermissionTo($view_field_research);
        $coordinator_role->givePermissionTo($add_patient_report);
        $coordinator_role->givePermissionTo($view_patient_report);
        $coordinator_role->givePermissionTo($delete_patient_report);
        $coordinator_role->givePermissionTo($add_supplies);
        $coordinator_role->givePermissionTo($view_hospital);
        $coordinator_role->givePermissionTo($view_contact_forms);
        $coordinator_role->givePermissionTo($view_activity_logs);
        $manager_role = Role::create(['name' => 'manager']);

        $manager_role->givePermissionTo($permissions);
        $manager_role->revokePermissionTo($delete_admin_users);



    }
}
