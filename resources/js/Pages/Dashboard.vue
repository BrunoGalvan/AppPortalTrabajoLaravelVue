<template>
    <div class="card">
        <div class="card-header">Dashboard</div>
        <div class="card-body">
            <div v-if="$can('can-view-worksplace_has_candidates')">

                <h4>Vista Administrador</h4>
                <hr>
                <h6>Funciones :</h6>
                <ol class="list-group list-group-numbered">
                    <li class="list-group-item">Ver listado de trabajos </li>
                    <li class="list-group-item">Crear/Editar/Eliminar trabajo</li>
                    <li class="list-group-item">Ver postulantes por cada trabajo</li>
                </ol>
                <br>
                <h6>Tegnologias principales usadas en la prueba:</h6>
                <ol class="list-group list-group-numbered">
                    <li class="list-group-item">Laravel 8</li>
                    <li class="list-group-item">Mysql 8</li>
                    <li class="list-group-item">Vue js 2.6.12</li>
                    <li class="list-group-item">Bootstrap 5.1.3</li>
                    <li class="list-group-item">Laravel-permission spatie 5.10</li>
                </ol>
                <br>
                <h6>Otras tecnologias usadas:</h6>
                <ol class="list-group list-group-numbered">
                    <li class="list-group-item">Sweetalert 2.1.2</li>
                    <li class="list-group-item">Vue-axios 3.5.2</li>
                    <li class="list-group-item">Vue-router 3.6.5</li>
                    <li class="list-group-item">Laravel-vue-pagination 2.3.1</li>
                </ol>
                <br>
                Nota: Registrarse antes de iniciar sesion para ingresar como postulante
            </div>
            <div v-if="$can('can-view-candidate_worksplaces_applications')">
                 <h4>Vista Postulante</h4>
                <hr>
                <h6>Funciones :</h6>
                <ol class="list-group list-group-numbered">
                    <li class="list-group-item">Ver listado de trabajos </li>
                    <li class="list-group-item">Postularse a un trabajo</li>
                    <li class="list-group-item">Ver postulaciones</li>
                </ol>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>