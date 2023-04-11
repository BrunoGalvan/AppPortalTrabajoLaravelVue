<template>
<div>
    <div class="modal fade" id="ModalCandidatesWorksplace" tabindex="-1" aria-hidden="true"
        v-if="$can('can-view-worksplace_has_candidates')">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5"> {{ TitleModal }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form>
                    <div class="modal-body">
                        <ol class="list-group list-group-numbered" v-if="candidates.length > 0">
                            <a href="#" v-for="candidate in candidates" :key="candidate.id"
                                class="list-group-item d-flex justify-content-between align-items-start"
                                @click="PostCandidateWorksplace(candidate)">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">{{ candidate.names }}&nbsp;{{ candidate.last_names }}</div>
                                    Correo: {{ candidate.email }}
                                </div>
                                <span class="badge bg-warning rounded-pill">Registrado: {{ candidate.created_at }}</span>
                            </a>
                        </ol>
                        <ol class="list-group list-group-numbered" v-else>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">
                                        No hay postulantes para este puesto
                                    </div>
                                </div>
                            </li>
                        </ol>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm"
                            style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;"
                            data-bs-dismiss="modal">
                            Cerrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <modal-post-candidate-worksplace @CandidatesWorksplace = 'CandidatesWorksplace' ref="ModalPostCandidateWorksplace"></modal-post-candidate-worksplace>
</div>
</template>
<script>
import ModalPostCandidateWorksplace from './ModalPostCandidateWorksplace.vue'

export default {
    data() {
        return { candidates: [], TitleModal: '' }
    },
    components: {
        ModalPostCandidateWorksplace,
    },
    mounted() {
        this.CandidatesWorksplace()
    },
    methods: {
        CandidatesWorksplace(worksplace_id) {
            this.axios.get('/api/candidates_has_worksplaces/' + worksplace_id).then(response => {
                this.candidates = response.data;
            }).catch(({ response }) => {
                console.error(response)
            });

        },
        PostCandidateWorksplace(data) {
            this.$refs.ModalPostCandidateWorksplace.PostCandidateText = { names: data.names, last_names: data.last_names, type_document: data.type_document, n_document: data.n_document, dates_birth: data.dates_birth, email: data.email, message: data.message, worksplaces_id: data.worksplaces_id, file_cv: data.file_cv }
            this.$refs.ModalPostCandidateWorksplace.TitleModal = 'Postulacion - ' + data.names
            $('#ModalCandidatesWorksplace').modal('hide')
            $('#ModalPostCandidateWorksplace').modal('show')
        }
    }
} 
</script>