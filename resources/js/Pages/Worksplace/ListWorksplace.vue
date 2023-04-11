<template>
    <div class="card" v-if="$can('can-view-worksplace')">
        <form-modal-worksplace @ListWorksplace="ListWorksplace" @ShowWorksplace="ShowWorksplace"
            ref="FormModalWorksplace"></form-modal-worksplace>
        <div class="card-header">
            <div class="row">
                <div class="col">
                    Puestos de trabajo
                </div>
                <div class="col" align="right">
                    <button v-if="$can('can-create-worksplace')" class="btn btn-secondary btn-sm"
                        @click="CreateFormModalWorksplace">
                        <i class="fas fa-plus-circle mr-1"></i> Crear puesto
                    </button>
                    <router-link v-if="$can('can-view-candidate_worksplaces_applications')" to="/worksplaces/post" class="btn btn-secondary btn-sm"><i class="fas fa-paper-plane mr-1"></i> Mis postulaciones</router-link>
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
                                <small>
                                    <button v-if="$can('can-edit-worksplace')" class="badge bg-secondary rounded-pill"
                                        @click="EditFormModalWorksplace(worksplace, worksplaces)"><i
                                            class="fas fa-edit"></i>
                                    </button>
                                    <button v-if="$can('can-deleted-worksplace')" class="badge bg-secondary rounded-pill"
                                        @click="DestroyWorksplace(worksplace)"><i class="fas fa-trash"></i>
                                    </button>
                                </small>
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
                                    No hay puestos creados.
                                </div>
                            </div>
                        </a>
                    </div>
                    <br>
                    <pagination align="center" :data="worksplaces" @pagination-change-page="ListWorksplace">
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
import FormModalWorksplace from '../../components/FormModalWorksplace.vue'
import ShowWorksplace from '../../components/ShowWorksplace.vue'

export default {
    name: "worksplaces",
    components: {
        pagination,
        FormModalWorksplace,
        ShowWorksplace
    },
    data() {
        return {
            worksplaces: {
                type: Object,
                default: null
            }
        }
    },
    mounted() {
        this.ListWorksplace()
    },
    methods:
    {
        async ListWorksplace(page = 1) {
            await axios.get('/api/worksplaces?page=' + page).then(({ data }) => {
                this.worksplaces = data
            }).catch(({ response }) => {
                console.error(response)
            })
        },
        DestroyWorksplace(data) {
            swal({
                title: "¿Está seguro de eliminar el puesto " + data.title + "?",
                text: "Se eliminara permanentemente!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        axios.delete('/api/worksplace/destroy/' + data.id).then(res => {
                            this.ListWorksplace(this.worksplaces.current_page)
                            this.$refs.ShowWorksplace.DivWorksplace = false
                            swal("Puesto eliminado correctamente!", {
                                icon: "success",
                            });
                        }).catch(function (error) {
                            var array = Object.values(error.response.data.errors)
                            array.forEach(element => swal(String(element)))
                        });

                    }
                });
        },
        ShowWorksplace(user_id,data) {
           this.$refs.ShowWorksplace.WorksplaceText = { id: data.id, title: data.title, description: data.description, workday: data.workday, salary: data.salary, created_at: data.created_at, updated_at: data.updated_at, candidates_has_worksplaces: data.candidates_has_worksplaces }
           this.$refs.ShowWorksplace.CheckPostWorksplace(user_id,data.id);
           this.$refs.ShowWorksplace.DivWorksplace = true

        },
        CreateFormModalWorksplace() {
            this.$refs.FormModalWorksplace.WorksplaceInput = { title: '', description: '', type_workday_id: '', salary: '' }
            this.$refs.FormModalWorksplace.TitleModal = 'Crear puesto'
            this.$refs.FormModalWorksplace.BtnCreate = true
            this.$refs.FormModalWorksplace.BtnEdit = false
            $('#FormModalWorksplace').modal('show')
        },
        EditFormModalWorksplace(data, page) {
            this.$refs.FormModalWorksplace.WorksplaceInput = { title: data.title, description: data.description, workday: data.workday, type_workday_id: data.workday_id, salary: data.salary, created_at: data.created_at, updated_at: data.updated_at, candidates_has_worksplaces: data.candidates_has_worksplaces }
            this.$refs.FormModalWorksplace.TitleModal = 'Editar puesto'
            this.$refs.FormModalWorksplace.BtnCreate = false
            this.$refs.FormModalWorksplace.BtnEdit = true
            this.$refs.FormModalWorksplace.IdWorksplace = data.id
            this.$refs.FormModalWorksplace.CurrentPage = page.current_page
            $('#FormModalWorksplace').modal('show')
        }
    }
}
</script>

<style scoped>
.pagination {
    margin-bottom: 0;
}
</style>