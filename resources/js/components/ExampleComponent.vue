<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example2 Component</div>

                    <div class="card-body">
                        <div id="app-4">
                        <ol>
                                        <li v-for="todo in todos">
                                          {{ todo.text }}
                                        </li>
                                      </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
