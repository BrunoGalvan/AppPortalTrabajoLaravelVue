<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        # Create an editor role
        $roleAdministrador = Role::create(['name' => 'ADMINISTRADOR']);

        # Create a supervisor role
        $rolePostulante = Role::create(['name' => 'POSTULANTE']);


        # Now lets create permissions and assign them to our freshly created roles
        $permissions = [
            'can-view-worksplace',
            'can-create-worksplace',
            'can-edit-worksplace',
            'can-deleted-worksplace',
            'can-view-worksplace_has_candidates',
            'can-view-candidate_worksplaces_applications',
            'can-create_post_worksplace'
        ];

        foreach ($permissions as $permissionName) {
            $permission = Permission::create(['name' => $permissionName]);

            if (in_array($permissionName, ['can-view-worksplace'])) {
                $rolePostulante->givePermissionTo($permission);
                $roleAdministrador->givePermissionTo($permission);
            } elseif(in_array($permissionName, ['can-view-candidate_worksplaces_applications', 'can-create_post_worksplace'])) {
                $rolePostulante->givePermissionTo($permission);
            }else{
                $roleAdministrador->givePermissionTo($permission);
            }
        }
    }
}
