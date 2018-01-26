<template id="users-template">
    <table class="table">
        <thead>
            <tr>
                <td>#</td>
                <td>{{ users.name }}</td>
                <td>email</td>
                <td>creation</td>
            </tr>
        </thead>
        <tbody>
            <tr v-for="user in users">
                <td>@{{ user.id }}</td>
                <td>@{{ user.name }}</td>
                <td>@{{ user.email }}</td>
                <td>@{{ user.date }}</td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        data: function() {
            return {
                users: []
            }
        },
        created: function() {
            this.getUsers();
        },
        methods: {
            getUsers: function() {
                this.users = [
                    {
                        'id' : '1', 
                        'name' : 'Allen Lamparas', 
                        'email' : 'abl@yahoo.com', 
                        'date' : 'date', 

                    },
                    {
                        'id' : '2', 
                        'name' : 'Kevin Lamparas', 
                        'email' : 'abl@yahoo.com', 
                        'date' : 'date', 

                    }
                ];
            }
        }
    }
</script>