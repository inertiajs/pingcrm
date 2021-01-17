<template>
  <div>
    <pre>
     {{ $page.props.tabs }}
   </pre>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'

export default {
  metaInfo: { title: 'Dashboard' },
  layout: Layout,
}
</script>
