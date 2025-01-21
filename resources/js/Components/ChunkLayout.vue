<script setup>
import {Client} from "twitter-api-sdk";

async function main() {
    try {
        const client = new Client(import.meta.env.VITE_BEARER_TOKEN);
        const response = await client.users.findUserByUsername("eMeKavelli", {
            "user.fields": ['id']
        });
        console.log(response);
    } catch (error) {
        console.error("Error fetching user:", error);
    }
}
main();
</script>

<template>

</template>

<style scoped>

</style>

