<template>
    <div class="modal fade" id="ModalCreatePostWorksplace" tabindex="-1" aria-hidden="true"
        v-if="$can('can-create_post_worksplace')">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5"> {{ TitleModal }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form @submit.prevent="CreatePostWorksplace">
                    <div class="modal-body">
                        <div class="row g-3">
                            <input hidden type="text" class="form-control" v-model="post.worksplace_id">
                            <input hidden type="text" class="form-control" v-model="post.user_id">

                            <div class="col-md-12">
                                <label class="form-label">Sube tu CV</label>
                                <div class="input-group mb-3">
                                    <input type="file" @change="select_file" class="form-control">
                                    <label class="input-group-text">Subir</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Mensaje</label>
                                <textarea type="text" class="form-control" v-model="post.message"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm"
                            style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;"
                            data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary btn-sm" v-if="$can('can-create_post_worksplace')"
                            style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">Enviar
                            postulacion</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            TitleModal :'',
            post: {
                user_id: '',
                worksplace_id: '',
                message: '',
                file_cv: null
            },
        }
    },
    methods: {
        select_file(event) {
            this.post.file_cv = event.target.files[0];
        },
        CreatePostWorksplace() {
            let post = new FormData();
            for (let key in this.post) {
                post.append(key, this.post[key]);
            }
            this.axios.post('/api/worksplace/post/create', post).then(response => {
                $('#ModalCreatePostWorksplace').modal('hide')
                swal("Felicidades!", "Se envio tu postulacion!", "success");
                this.$emit('CheckPostWorksplace',this.post.user_id,this.post.worksplace_id)
            }).catch(function (error) {
                var array = Object.values(error.response.data.errors)
                array.forEach(element => swal(String(element)))
            });
        },
    }
} 
</script>