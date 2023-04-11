<template>
    <div class="modal fade" id="ModalPostCandidateWorksplace" tabindex="-1" aria-hidden="true" v-if="$can('can-view-worksplace_has_candidates')">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5"> {{ TitleModal }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form>
                    <div class="modal-body">
                        <h2 class="fs-5">Informacion de postulante</h2>
                        <p><strong>Nombres:</strong> {{ PostCandidateText.names }}</p>
                        <p><strong>Apellidos:</strong> {{ PostCandidateText.last_names }}</p>
                        <p><strong>{{ PostCandidateText.type_document }}:</strong> {{ PostCandidateText.n_document }}
                        </p>
                        <p><strong>Fecha de Nacimiento:</strong> {{ PostCandidateText.dates_birth }}</p>
                        <p><strong>Email:</strong> {{ PostCandidateText.email }}</p>
                        <hr>
                        <div class="mb-3">
                            <strong>Mensaje:</strong><br>
                            {{ PostCandidateText.message }}
                        </div>
                        <div class="mb-3">
                            <button @click="downloadDocument(PostCandidateText.file_cv)" type="button" class="btn btn-dark btn-sm">Descargar CV</button>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button @click="ModalCandidatesWorksplace(PostCandidateText.worksplaces_id)" type="button" class="btn btn-secondary btn-sm" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;" data-bs-dismiss="modal">
                            Volver a lista
                        </button>
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
                PostCandidateText: {},
                TitleModal: ''
            }
        },
        methods: {
            ModalCandidatesWorksplace(worksplace_id) {
                $('#ModalPostCandidateWorksplace').modal('hide')
                this.$emit('CandidatesWorksplace', worksplace_id)
                $('#ModalCandidatesWorksplace').modal('show')
            },
            async downloadDocument(file) {
                axios.get('/api/worksplace/candidate/download/' + file, {
                    responseType: 'arraybuffer'
                }).then(res => {
                    let blob = new Blob([res.data], {
                        type: 'application/*'
                    })
                    let link = document.createElement('a')
                    link.href = window.URL.createObjectURL(blob)
                    link.download = file
                    link._target = 'blank'
                    link.click();
                })
            },

        }

    }
</script>