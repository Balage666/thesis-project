<script setup>

import { Link } from '@inertiajs/inertia-vue3'

import LanguageSwitcher from '../Components/Language/LanguageSwitcher.vue';

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
            <h2>{{ route().has('storefront') }}</h2>
            <hr>
            <img
                :src="$page.props.active_session.user.profile_picture"
                :title="$page.props.active_session.user.name"
                :alt="$page.props.active_session.user.name"
            >
        </div>

        <div>
            <LanguageSwitcher/>
        </div>

        <Link
            v-if="$page.props.active_session.user"
            class="btn btn-outline btn-lg btn-warning fw-bold"
            :href="route('log-out')"
        >
            {{ __("Log Out") }}
        </Link>
    </div>
</template>
