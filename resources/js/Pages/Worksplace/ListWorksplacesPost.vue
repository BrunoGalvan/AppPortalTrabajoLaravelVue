<template>
    <div class="card" v-if="$can('can-view-candidate_worksplaces_applications')">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    Mis postulaciones
                </div>
                <div class="col" align="right">
                    <router-link  v-if="$can('can-view-worksplace')" to="/worksplaces" class="btn btn-secondary btn-sm"><i class="fa fa-briefcase"></i> Ver todos los puestos</router-link>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="list-group" v-if="worksplaces && worksplaces.data.length > 0">
                        <a href="#" v-for="(worksplace, index) in worksplaces.data" :key="index"
                            class="list-group-item list-group-item-action" aria-current="true"
                            @click="ShowWorksplace($userId,worksplace)">
                            <div class="d-flex w-100 justify-content-between">
                                <h4 class="mb-1">{{ worksplace.title }}</h4>
                            </div>
                            <small>
                                <strong><i class="fa fa-briefcase"></i>&nbsp;{{ worksplace.workday }}&nbsp;&nbsp;</strong>
                                <strong><i class="fa fa-money"></i>&nbsp;PEN {{ worksplace.salary }}</strong>
                            </small>
                        </a>
                    </div>
                    <div class="list-group" v-else>
                        <a class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <div align="center">
                                    No hay puestos postulados
                                </div>
                            </div>
                        </a>
                    </div>
                    <br>
                    <pagination align="center" :data="worksplaces" @pagination-change-page="ListWorksplacePost">
                    </pagination>
                    <br>
                </div>
                <div class="col-md-8">
                    <show-worksplace ref="ShowWorksplace"></show-worksplace>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import pagination from 'laravel-vue-pagination'
import ShowWorksplace from '../../components/ShowWorksplace.vue'

export default {
    name: "worksplaces",
    components: {
        pagination,
        ShowWorksplace
    },
    data() {
        return {
            user_id :this.$userId,
            worksplaces: {
                type: Object,
                default: null
            }
        }
    },
    mounted() {
        this.ListWorksplacePost(1,this.user_id)
    },
    methods:
    {
        async ListWorksplacePost(page,user_id) {
            await axios.get('/api/worksplaces/candidate/'+ user_id +'?page=' + page).then(({ data }) => {
                this.worksplaces = data
            }).catch(({ response }) => {
                console.error(response)
            })
        },
        ShowWorksplace(user_id,data) {
           this.$refs.ShowWorksplace.WorksplaceText = { id: data.id, title: data.title, description: data.description, workday: data.workday, salary: data.salary, created_at: data.created_at, updated_at: data.updated_at, candidates_has_worksplaces: data.candidates_has_worksplaces }
           this.$refs.ShowWorksplace.CheckPostWorksplace(user_id,data.id);
           this.$refs.ShowWorksplace.DivWorksplace = true

        }
    }
}
</script>

<style scoped>
.pagination {
    margin-bottom: 0;
}
</style>