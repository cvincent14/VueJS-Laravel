<template>
    <div>
        <form  @submit.prevent="submitComment">
            <div>
                <h3 class="">Nouveau commentaire</h3>
                <p v-if="respondTo">
                    En réponse à <span class="">{{ respondTo.name }}</span> : " {{ respondTo.body }} ".
                    <button type="button" @click="$emit('cancel-respond-to')">Annuler</button>
                </p>
            </div>
            <div class="mb-3">
                <input type="text" class="border rounded form-control p-3" :class="{ 'border border-danger' : errors.name}" v-model="form.name" placeholder="Pseudo">
                <p class="text-danger px-3 py-1"  v-if="errors.name" v-text="errors.name[0]"></p>
            </div>
            <div class="mb-3">
                <textarea class="border rounded form-control p-3" :class="{ 'border border-danger' : errors.body}" v-model="form.body" placeholder="Commentaire"></textarea>
                <p class="text-danger px-3 py-1" v-if="errors.body" v-text="errors.body[0]"></p>
            </div>
            

            <button type="submit" class="border rounded btn btn-outline-secondary py2">Commenter</button>
        </form>
    </div>
</template>

<script>

    export default {
        props:['respondTo'],
        
        data(){
            return{
                form:{
                    name: '',
                    body: '',
                    url: window.location.href,
                },
                errors: {},
            }
        },

        computed: {
            fullForm(){
                if(this.respondTo){
                    return {
                        ...this.form,
                        respond_to_id: this.respondTo.id,
                    }
                }
                return this.form
            }
        },

        methods :{ 
            submitComment(){
                axios.post('/comments', this.fullForm)
                    .then(({data}) => {
                        this.$emit('newComment', data)
                        this.form.body = "" 
                        this.errors = {} 
                    })
                    .catch(error => {
                        this.errors = error.response.data.errors
                    })      
            },

        },      
    }
 
</script>