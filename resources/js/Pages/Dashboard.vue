<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import axios from "@/axios";
import { Head, router } from "@inertiajs/vue3";
import Dropdown from "@/Components/Dropdown.vue";
import { reactive } from "vue";
import PaginationLinks from "@/Components/PaginationLinks.vue";

const props = defineProps({
    transactions: {},
});

console.log("[TRANSACTIONS]", props.transactions);

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

const currencyFormatter = new Intl.NumberFormat("en-US", {
    style: "currency",
    currency: "USD",

    // These options are needed to round to whole numbers if that's what you want.
    //minimumFractionDigits: 0, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
    //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
});

const formatPaymentChannel = (paymentChannel) => {
    return {
        online: "Online",
        in_store: "In Store",
        other: "Other",
    }[paymentChannel];
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
                    <div class="flex flex-col">
                        <div class="-m-1.5 overflow-x-auto">
                            <div
                                class="p-1.5 min-w-full inline-block align-middle"
                            >
                                <div class="overflow-hidden">
                                    <table
                                        class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700"
                                    >
                                        <thead>
                                            <tr>
                                                <th
                                                    scope="col"
                                                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500"
                                                >
                                                    Bank
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500"
                                                >
                                                    Transaction
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500"
                                                >
                                                    Amount
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500"
                                                >
                                                    Type
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500"
                                                >
                                                    Datetime
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500"
                                                >
                                                    Channel
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500"
                                                >
                                                    Category
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody
                                            class="divide-y divide-gray-200 dark:divide-neutral-700"
                                        >
                                            <tr
                                                v-for="transaction in props
                                                    .transactions.data"
                                                :key="transaction.id"
                                            >
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200"
                                                >
                                                    <div class="flex flex-col">
                                                        <span class="">{{
                                                            transaction
                                                                .bank_account
                                                                .bank.name
                                                        }}</span>
                                                        <span
                                                            class="block text-xs font-semibold text-gray-400"
                                                            >{{
                                                                transaction
                                                                    .bank_account
                                                                    .mask
                                                            }}</span
                                                        >
                                                    </div>
                                                </td>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200"
                                                >
                                                    {{
                                                        transaction.merchant_name
                                                    }}
                                                </td>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200"
                                                >
                                                    <div
                                                        class="flex justify-end"
                                                    >
                                                        <span
                                                            class="inline-block"
                                                            >{{
                                                                transaction.transaction_type ===
                                                                "debit"
                                                                    ? "-"
                                                                    : "+"
                                                            }}</span
                                                        >
                                                        <span
                                                            class="inline-block"
                                                            >{{
                                                                currencyFormatter.format(
                                                                    transaction.amount
                                                                )
                                                            }}</span
                                                        >
                                                    </div>
                                                </td>

                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200"
                                                >
                                                    {{
                                                        transaction.transaction_type
                                                    }}
                                                </td>

                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200"
                                                >
                                                    {{
                                                        transaction.formatted_spent_at
                                                    }}
                                                </td>

                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200"
                                                >
                                                    {{
                                                        formatPaymentChannel(
                                                            transaction.payment_channel
                                                        )
                                                    }}
                                                </td>

                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200"
                                                >
                                                    {{ transaction.category }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <PaginationLinks
                                        class="mt-2"
                                        :links="props.transactions.links"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
