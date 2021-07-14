<template>
  <div class="invitation-item d-flex justify-content-between align-items-center py-4">
    <div class="d-flex align-items-center">
      <div class="invitation-item__icon mr-3">
        <i class="la la-envelope"></i>
      </div>
      <div class="invitation-item__receiver d-flex flex-column">
        <span class="invitation-item__receiver__name">
          {{ `${invitation.receiver.prename} ${invitation.receiver.name}` }}
        </span>
        <a :href="`mailTo:${invitation.receiver.email}`" class="invitation-item__receiver__email">
          {{ invitation.receiver.email }}
        </a>
      </div>
    </div>
    <div class="invitation-item__info d-flex flex-column align-items-end">
      <span class="invitation-item__status text-capitalize">{{ invitation.status }}</span>
      <span class="invitation-item__date">{{ daysAgo(invitation) }}</span>
    </div>
  </div>
</template>

<script>
import dayjs from "dayjs";
const utc = require('dayjs/plugin/utc');
const timezone = require('dayjs/plugin/timezone');
const relativeTime = require("dayjs/plugin/relativeTime");
dayjs.extend(utc);
dayjs.extend(timezone);
dayjs.extend(relativeTime);

export default {
  data: () => ({}),
  props: ["invitation"],

  methods: {
    daysAgo: function () {
      const days = dayjs(this.invitation.createdAt).tz('Europe/Berlin').fromNow();
      return days;
    },
  },
};
</script>
