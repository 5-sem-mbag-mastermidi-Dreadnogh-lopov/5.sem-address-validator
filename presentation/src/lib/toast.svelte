<script>
    import { flip } from "svelte/animate";
    import { fly } from "svelte/transition";
    import { notifications } from "./stores/notifications.js";

    export let themes = {
        danger: "bg-red-500 text-white",
        success: "bg-green-500 text-white",
        warning: "bg-yellow-500",
        info: "bg-blue-500 text-white",
        default: "bg-gray-500",
    };
</script>

<div class="fixed right-10 top-20 flex flex-col items-center select-none">
    {#each $notifications as notification (notification.id)}
        <div
            animate:flip
            class="rounded p-2 mb-2 {themes[notification.type]}"
            transition:fly={{ x: 100, duration: 400 }}
        >
            <div class="">{notification.message}</div>
            {#if notification.icon}<i class={notification.icon} />{/if}
        </div>
    {/each}
</div>
