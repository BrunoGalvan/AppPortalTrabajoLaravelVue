<template>
    <div class="card" v-if="$can('can-view-worksplace')">
        <modal-candidates-worksplace ref="ModalCandidatesWorksplace"></modal-candidates-worksplace>
        <modal-create-post-worksplace ref="ModalCreatePostWorksplace"
            @CheckPostWorksplace='CheckPostWorksplace'></modal-create-post-worksplace>
        <div class="card-body">

            <div v-if="DivWorksplace">
                <article class="blog-post">
                    <h2 class="blog-post-title mb-1">{{ WorksplaceText.title }}</h2>
                    <p class="blog-post-meta">
                        Creacion: {{ WorksplaceText.created_at }},
                        Actualizado: {{ WorksplaceText.updated_at }}
                    </p>
                    <p class="blog-post-meta">
                        <strong>
                            <i class="fa fa-briefcase"></i>
                            &nbsp;{{ WorksplaceText.workday }}&nbsp;&nbsp;
                        </strong>
                        <strong>
                            <i class="fa fa-money"></i>
                            &nbsp;PEN {{ WorksplaceText.salary }}
                        </strong>
                    </p>

                    <p>{{ WorksplaceText.description }}</p>
                </article>
                <nav class="blog-pagination" aria-label="Pagination">
                    <div v-if="infoPost">
                        <strong v-if="$can('can-create_post_worksplace')">Postulacion enviada</strong>
                    </div>
                    <div v-if="btnCreatePost">
                        <a v-if="$can('can-create_post_worksplace')" class="btn btn-outline-secondary rounded-pill"
                            @click="CreatePostWorksplaceModal(WorksplaceText.title, WorksplaceText.id, $userId)">Postularme</a>
                    </div>
                    <a v-if="$can('can-view-worksplace_has_candidates')" class="btn btn-outline-secondary rounded-pill"
                        @click="CandidatesWorksplaceModal(WorksplaceText.id, WorksplaceText.title)">{{
                            WorksplaceText.candidates_has_worksplaces }} candidatos
                        postulados</a>
                </nav>
            </div>
            <div v-else>
                <div align="center">
                    Selecciona un puesto.
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import ModalCandidatesWorksplace from './ModalCandidatesWorksplace.vue'
import ModalCreatePostWorksplace from './ModalCreatePostWorksplace.vue'

export default {
    data() {
        return {
            WorksplaceText: {},
            DivWorksplace: '',
            infoPost: '',
            btnCreatePost: '',

        }
    },
    components: {
        ModalCandidatesWorksplace,
        ModalCreatePostWorksplace,
    },
    methods: {
        CandidatesWorksplaceModal(worksplace_id, worksplace_title) {
            this.$refs.ModalCandidatesWorksplace.CandidatesWorksplace(worksplace_id);
            this.$refs.ModalCandidatesWorksplace.TitleModal = 'Postulantes - ' + worksplace_title
            $('#ModalCandidatesWorksplace').modal('show')
        },
        CreatePostWorksplaceModal(worksplace_title, worksplace_id, user_id) {
            this.$refs.ModalCreatePostWorksplace.post = {
                message: '',
                worksplace_id: worksplace_id,
                user_id: user_id
            }
            this.$refs.ModalCreatePostWorksplace.TitleModal = 'Postular - ' + worksplace_title
            $('#ModalCreatePostWorksplace').modal('show')
        },
        CheckPostWorksplace(user_id, worksplace_id) {
            this.axios.get('/api/checkpost/' + user_id + '/' + worksplace_id).then(response => {
                this.checkpost = response.data
                if (this.checkpost.length > 0) {
                    this.infoPost = true
                    this.btnCreatePost = false
                } else {
                    this.infoPost = false
                    this.btnCreatePost = true
                }
            }).catch(error => {
                console.log(error)
                this.checkpost = []
            })
        },
    }
}
</script>