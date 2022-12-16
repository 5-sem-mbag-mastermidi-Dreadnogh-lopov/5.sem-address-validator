<script>
    import { onMount } from "svelte";
    import { JSONToDisplay } from "../../../stores/cache.store";
    let content = {
        json: $JSONToDisplay,
    };
    let JSONEditor;
    onMount(async () => {
        JSONEditor = (await import("svelte-jsoneditor")).JSONEditor;
    });
</script>

<div class="editor my-json-editor">
    <svelte:component this={JSONEditor} bind:content />
</div>

<style>
    .my-json-editor {
        /* define a custom theme color */
        --jse-theme-color: #22c55e;
        --jse-theme-color-highlight: rgba(255, 255, 255, 0.555);
        width: 800px;
        height: 500px;
    }
</style>
