<template>
  <div class="widget widget-form">
    <h3 class="widget-title">Sender Details</h3>
    <div class="contct-info mb-0">
      <div class="contct-nf pl-0">
        <h3 class="mb-2">{{ senderName }}</h3>
        <h4 class="d-flex align-items-center mb-2">
          <a :href="`mailto:${sender.email}`" class="d-flex align-items-center">
            <i class="la la-envelope"></i>
            {{ sender.email }}
          </a>
        </h4>
        <h4 class="d-flex align-items-center">
          <a :href="`tel:${sender.phone}`" class="d-flex align-items-center">
            <i class="la la-phone"></i>
            {{ sender.phone }}
          </a>
        </h4>
        <p>{{ sender.message }}</p>
        <!-- <a :href="`tel:${offer.seller.phone}`">
          <i class="la la-phone"></i>{{ offer.seller.phone }}
        </a> -->
      </div>
    </div>
    <!--contct-info end-->
  </div>
  <!--widget-form end-->
</template>

<script>
export default {
  name: "RequestSender",
  props: ['sender'],
  computed: {
    senderName () {
      return `${this.sender.prename} ${this.sender.name}`;
    },
  },
};
</script>
