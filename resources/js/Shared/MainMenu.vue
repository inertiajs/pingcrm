<template>
  <div>
    <div class="mb-4">

      <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('addresses')">
        <icon name="location-marker" class="w-4 h-4 mr-2" :class="isUrl('addresses') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('addresses') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Addresses</div>
      </inertia-link>
    </div>

    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('banks')">
        <icon name="cash" class="w-4 h-4 mr-2" :class="isUrl('banks') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('banks') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Bank Details</div>
      </inertia-link>
    </div>


    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('officerule')">
        <icon name="scale" class="w-4 h-4 mr-2" :class="isUrl('officerule') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('officerule') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Office Rule</div>
      </inertia-link>
    </div>
    
    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('rulecategory')">
        <icon name="clipboard-list" class="w-4 h-4 mr-2" :class="isUrl('rulecategory') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('rulecategory') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Rule Category</div>
      </inertia-link>
    </div>

    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('budgets')">
        <icon name="scale" class="w-4 h-4 mr-2" :class="isUrl('budgets') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('budgets') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Budgets</div>
      </inertia-link>
    </div>

    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('comments')">
        <icon name="pencil" class="w-4 h-4 mr-2" :class="isUrl('comments') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('comments') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Comments</div>
      </inertia-link>
    </div>


    <div class="mb-4">6
      <inertia-link class="flex items-center group py-3" :href="route('comments')">
        <icon name="pencil" class="w-4 h-4 mr-2" :class="isUrl('comments') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('comments') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Comments</div>
      </inertia-link>
    </div>

    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('contacts')">
        <icon name="phone" class="w-4 h-4 mr-2" :class="isUrl('contacts') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('contacts') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Contacts</div>
      </inertia-link>
    </div>


    
    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('clients')">
        <icon name="user-group" class="w-4 h-4 mr-2" :class="isUrl('clients') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('clients') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Clients</div>
      </inertia-link>
    </div>

      <inertia-link class="flex items-center group py-3" :href="route('dashboard')">
        <icon name="server" class="w-4 h-4 mr-2" :class="isUrl('') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Dashboard</div>
      </inertia-link>
    </div>

    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('documents')">
        <icon name="folder-open" class="w-4 h-4 mr-2" :class="isUrl('documents') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('documents') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Documents</div>
      </inertia-link>
    </div>

    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('educations')">
        <icon name="academic-cap" class="w-4 h-4 mr-2" :class="isUrl('educations') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('educations') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Educations</div>
      </inertia-link>
    </div>

    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('followups')">
        <icon name="paper-airplane" class="w-4 h-4 mr-2" :class="isUrl('followups') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('followups') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Followups</div>
      </inertia-link>
    </div>


     <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('issues')">
         <icon name="office-building" class="w-4 h-4 mr-2" :class="isUrl('followups') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('issues') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Issues</div>
      </inertia-link>
    </div>
    
   


    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('leaves')">
        <icon name="cash" class="w-4 h-4 mr-2" :class="isUrl('leaves') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('leaves') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Leaves</div>
      </inertia-link>
    </div>


    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('organizations')">
        <icon name="office-building" class="w-4 h-4 mr-2" :class="isUrl('organizations') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('organizations') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Company</div>
      </inertia-link>
    </div>

     <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('projects')">
        <icon name="briefcase" class="w-4 h-4 mr-2" :class="isUrl('projects') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('projects') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Projects</div>
      </inertia-link>
    </div>


    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('organizations')">
        <icon name="office-building" class="w-4 h-4 mr-2" :class="isUrl('organizations') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('organizations') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Company</div>
      </inertia-link>
    </div>

     <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('projects')">
        <icon name="briefcase" class="w-4 h-4 mr-2" :class="isUrl('projects') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('projects') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Projects</div>
      </inertia-link>
    </div>

     <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('reports')">
        <icon name="newspaper" class="w-4 h-4 mr-2" :class="isUrl('reports') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('reports') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Reports</div>
      </inertia-link>
    </div>

    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('profiles')">
        <icon name="user-circle" class="w-4 h-4 mr-2" :class="isUrl('profiles') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('profiles') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Profiles</div>
      </inertia-link>
    </div>

  
    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('restaurants')">
        <icon name="fire" class="w-4 h-4 mr-2" :class="isUrl('restaurants') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('restaurants') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Restaurants</div>
      </inertia-link>
    </div>
     
    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('tasks')">
        <icon name="clipboard-list" class="w-4 h-4 mr-2" :class="isUrl('tasks') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('tasks') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Tasks</div>
      </inertia-link>
    </div>

     
   
  
    


    

    


    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('users')">
        <icon name="users" class="w-4 h-4 mr-2" :class="isUrl('users') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('users') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Users</div>
      </inertia-link>
    </div>

   

    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('issues')">
        <icon name="office" class="w-4 h-4 mr-2" :class="isUrl('issues') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('issues') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Issues</div>
      </inertia-link>
    </div>

    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('contacts')">
        <icon name="phone" class="w-4 h-4 mr-2" :class="isUrl('contacts') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('contacts') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Contacts</div>
      </inertia-link>
    </div>

    
    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('reports')">
        <icon name="newspaper" class="w-4 h-4 mr-2" :class="isUrl('reports') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('reports') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Reports</div>
      </inertia-link>
    </div>

     <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('holidays')">
        <icon name="newspaper" class="w-4 h-4 mr-2" :class="isUrl('holidays') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('holidays') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Holidays</div>
      </inertia-link>
    </div>

  </div>
</template>

<script>
import Icon from '@/Shared/Icon'

export default {
  components: {
    Icon,
  },
  methods: {
    isUrl(...urls) {
      let currentUrl = this.$page.url.substr(1)
      if (urls[0] === '') {
        return currentUrl === ''
      }
      return urls.filter(url => currentUrl.startsWith(url)).length
    },
  },
}
</script>
