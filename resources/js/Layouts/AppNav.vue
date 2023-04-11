<template>
    <ul class="navbar-nav me-auto">
        <li class="nav-item">
            <router-link to="/" class="nav-link">Dashboard</router-link>
        </li>
        <li v-if="$can('can-view-worksplace')" class="nav-item">
            <router-link to="/worksplaces" class="nav-link">Puestos de trabajo</router-link>
        </li>
    </ul>
    
</template>
<script>
export default {}
</script>