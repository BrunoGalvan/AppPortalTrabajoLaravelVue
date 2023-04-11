<template>
    <div class="modal fade" id="FormModalWorksplace" tabindex="-1" aria-hidden="true" v-if="$can('can-create-worksplace') || $can('can-edit-worksplace')">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5"> {{ TitleModal }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Titulo</label>
                                <input type="text" class="form-control" v-model="WorksplaceInput.title">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Descripcion</label>
                                <textarea type="text" class="form-control" v-model="WorksplaceInput.description"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jornada</label>
                                <select class="form-select" v-model="WorksplaceInput.type_workday_id">
                                    <option v-for="workday in workdays" :key="workday.id" :value=workday.id
                                        :selected="WorksplaceInput.workday_id == workday.id ? true : false">
                                        {{ workday.name }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Salario</label>
                                <input type="number" class="form-control" v-model="WorksplaceInput.salary">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm"
                            style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;"
                            data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary btn-sm" @click.prevent="CreateWorksplace"
                            v-if="BtnCreate"
                            style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">Guardar</button>
                        <button type="submit" class="btn btn-primary btn-sm" @click.prevent="UpdateWorksplace"
                            v-if="BtnEdit"
                            style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return { WorksplaceInput: {}, workdays: [], TitleModal: '', BtnCreate: '', BtnEdit: '' }
    },
    created() {
        this.axios.get('/api/workday/options').then(response => {
            this.workdays = response.data;
        });
    },
    methods: {
        CreateWorksplace() {
            this.axios.post('/api/worksplace/create', this.WorksplaceInput).then(response => {
                this.$emit('ListWorksplace')
                $('#FormModalWorksplace').modal('hide')
                swal("Felicidades!", "Puesto creado correctamente!", "success");
            }).catch(function (error) {
                var array = Object.values(error.response.data.errors)
                array.forEach(element => swal(String(element)))
            });
        },
        UpdateWorksplace() {
            axios.put('/api/worksplace/update/' + this.IdWorksplace, this.WorksplaceInput).then(response => {
                this.IdWorksplace = ''
                this.$emit('ListWorksplace',this.CurrentPage)
                this.$emit('ShowWorksplace',this.$userId,this.WorksplaceInput)
                $('#FormModalWorksplace').modal('hide')
                swal("Felicidades!", "Puesto editado correctamente!", "success");
            }).catch(function (error) {
                var array = Object.values(error.response.data.errors)
                array.forEach(element => swal(String(element)))
            });
        },
    }
} 
</script>