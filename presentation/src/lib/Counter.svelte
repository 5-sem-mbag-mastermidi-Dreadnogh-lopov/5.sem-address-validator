<script>
  let count = 0
  const increment = () => {
    count += 1
  }
</script>

<button
  class="bg-[#f9f9f9] rounded-lg px-5 py-2 font-medium border border-transparent
    hover:border-[#646cff]"
  on:click={increment}
>
  count is {count}
</button>
