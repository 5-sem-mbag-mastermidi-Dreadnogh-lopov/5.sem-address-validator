<script>
  import svelteLogo from './assets/svelte.svg'
  import Counter from './lib/Counter.svelte'
</script>

<main
  class="h-screen flex flex-col items-center justify-center 
    text-[#213547]"
>
  <div class="flex">
    <a href="https://vitejs.dev" target="_blank">
      <img
        src="/vite.svg"
        class="h-36 p-6 hover:drop-shadow-[0_0_2em_#646cffaa]"
        alt="Vite Logo"
      />
    </a>
    <a href="https://svelte.dev" target="_blank">
      <img
        src={svelteLogo}
        class="h-36 p-6 hover:drop-shadow-[0_0_2em_#ff3e00aa]"
        alt="Svelte Logo"
      />
    </a>
  </div>
  <h1 class="text-5xl font-bold my-8">Vite + Svelte</h1>

  <div class="py-12">
    <Counter />
  </div>

  <p>
    Check out <a
      class="text-[#646cff] font-medium hover:text-[#747bff]"
      href="https://github.com/sveltejs/kit#readme"
      target="_blank">SvelteKit</a
    >, the official Svelte app framework powered by Vite!
  </p>

  <p class="text-[#888] my-4">
    Click on the Vite and Svelte logos to learn more
  </p>
</main>
