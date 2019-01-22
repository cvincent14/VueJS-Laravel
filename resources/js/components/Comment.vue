<template>
    <div>
        <div class="border rounded ">
            <div class="mb-2 p-3">
                <p class="text-muted "><small>

                    {{ comment.name }} -- Il y a {{ diffForHumans }}

                </small></p>
                {{ comment.body}}
            </div>
            <p class="px-3">
                <button type="button" @click="$emit('respond-to', comment)">
                    Répondre
                </button>
            </p>
        </div>
        <div class="mt-4 border-l-4 pl-4">
            <comment 
                class=" mb-4" 
                v-for="child in comment.children"
                :key="child.id" 
                :comment="child" 
                :now="now"        
                @respond-to="$emit('respond-to', $event)"
            ></comment>
        </div>
    </div>

        
</template>

<script>
    import { formatDistance } from 'date-fns'
    import { fr } from 'date-fns/esm/locale'
    

    export default {
        name: 'comment',
        props: ['comment', 'now'],  

        computed :{ 

            diffForHumans() {
                return formatDistance(new Date(this.comment.created_at), this.now, { locale : fr })
            }
        },  
    }
 
</script>