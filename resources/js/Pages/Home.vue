<script setup>

import { Link } from '@inertiajs/inertia-vue3'

</script>

<template>
    <div>
        <h1>Vue3 test</h1>

        <div v-if="$page.props.active_session.user">
            <h2>{{ $page.props.active_session.user.name }}</h2>
            <hr>
            <h2>{{ $page.props.active_session.user.email }}</h2>
            <hr>
            <h2>{{ $page.props.active_session.user }}</h2>
            <hr>
            <img
                :src="$page.props.active_session.user.profile_picture"
                :title="$page.props.active_session.user.name"
                :alt="$page.props.active_session.user.name"
            >
        </div>




        <Link v-if="$page.props.active_session.user" href="/auth/log-out">Log Out!</Link>
    </div>
</template>
