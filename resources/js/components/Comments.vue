<template>
    <div>
        <div class="border-b pb-4 mb-8">
            <comment 
                class=" mb-4" 
                :key="comment.id" 
                :comment="comment" 
                :now="now" 
                v-for="comment in comments"
                @respond-to="respondTo = $event"
            ></comment>
            <div v-if="nextPage">
                <button @click="fetchComments(nextPage)">
                    Charger les {{ numberOfComments - comments.length }} commentaires suivants...
                </button>
            </div>
        </div>
        <comment-form 
        @newComment="newComment"
        @cancel-respond-to="respondTo = null"
        :respond-to="respondTo"></comment-form>
    </div>
</template>

<script>
    import CommentForm from './CommentForm.vue'
    import Comment from './Comment.vue'

    export default {
        components: { CommentForm, Comment },
        data(){
            return{
                respondTo: null,
                nextPage: null,
                numberOfComments: 0,
                comments: [],
                now: new Date(),
            }
        },
        mounted(){
            //Permet d'actualiser le temps toutes les secondes
            setInterval(() => {
                this.now = new Date()
            }, 1000)


            this.fetchComments('/comments/' + btoa(window.location.href))

        },

        methods:{
            fetchComments(url){
                axios.get(url)
                    .then(({data : pagination}) => {
                    this.comments = this.comments.concat(pagination.data)
                    this.nextPage = pagination.next_page_url
                    this.numberOfComments = pagination.total
                })
            },

            newComment(comment){
                if(!this.respondTo){
                    this.comments.push(comment)
                    return
                }

                this.respondTo.children.push(comment)
            }
        }
             
    }
 
</script>