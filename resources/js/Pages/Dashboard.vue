<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import axios from "@/axios";
import { Head, router } from "@inertiajs/vue3";

const handleSubmitPublicToken = async (publicToken) => {
    try {
        await axios.post(route("public.token"), {
            public_token: publicToken,
        });
        router.reload({ only: ["dashboard"] });
    } catch (error) {
        console.log("[ERROR]", error.response.data.message);
    }
};

const createLinkToken = async () => {
    const {
        data: { data },
    } = await axios.post(route("link.token.create"));

    const handler = await Plaid.create({
        token: data.link_token,
        onSuccess: async (public_token, metadata) => {
            console.log("[ON SUCCESS]", public_token, metadata);

            await handleSubmitPublicToken(public_token);
        },
        onLoad: () => {
            console.log("[ON LOAD]");
        },
        onExit: (err, metadata) => {
            console.log("[ERROR]", err, metadata);
        },
        onEvent: (eventName, metadata) => {
            console.log(`[${eventName}]`, metadata);
        },
    });

    handler.open();
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="w-full px-4 md:px-0 flex md:justify-end">
                    <PrimaryButton
                        @click="createLinkToken"
                        class="w-full md:w-auto h-12"
                    >
                        Link an account
                    </PrimaryButton>
                </div>

                <div
                    class="mt-4 bg-white overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">You're logged in!</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
