<script>
    import { JSONEditor } from "svelte-jsoneditor";
    import { JSONToDisplay } from "../../../stores/cache.store";
    let content = {
        json: $JSONToDisplay,
    };
</script>

<svelte:head>
    <title>JSONEditor</title>
</svelte:head>
<div class="editor my-json-editor">
    <JSONEditor bind:content />
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
