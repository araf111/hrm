<template>
  <div class="card">
    <div class="card-header card-title-with-btn">
      <div class="card-title-text">ভ্রমণ ভাতা বিলের তালিকা</div>
      <div class="card-title-btns">
        <a class="btn btn-success" :href="addRoute">
          <i class="fa fa-plus"></i>
          নতুন বিল তৈরি
        </a>
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead>
          <tr>
            <th>চাহিদা নম্বর</th>
            <th>বিল জমাদানের তারিখ</th>
            <th>বিলের নম্বর</th>
            <th>স্ট্যাটাস</th>
            <th>অ্যাকশন</th>
          </tr>
          </thead>
          <tbody>
          <tr
            v-if="bills.length"
            v-for="bill in filteredBills"
            :key="bill.id"
            class="text-center"
          >
            <td>{{bill.submission_no}}</td>
            <td>{{bill.submission_date}}</td>
            <td>{{bill.bill_no}}</td>
            <td>{{bill.status.name_bn}}</td>
            <td>
              <button
                class="btn btn-info"
                @click="sendToViewRoute(bill.id)"
              >
                <i class="fa fa-eye"></i> দেখুন
              </button>
              <button
                v-if="!isSubmitted(bill)"
                class="btn btn-success"
                @click="sendToEditRoute(bill.id)"
              >
                <i class="fa fa-edit"></i>
              </button>
              <button
                v-if="!isSubmitted(bill)"
                class="btn btn-danger"
                @click="deleteBill(bill.id)"
              >
                <i class="fa fa-trash"></i>
              </button>
            </td>
          </tr>
          <tr v-if="!bills.length">
            <td colspan="5" class="lead text-center">কোনো বিল নাই</td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import './TravelAllowance.scss';
import axios from 'axios';

export default {
  props: {
    bills: {
      type: Array,
      required: true
    },
    viewRoute: {
      type: String,
      required: true
    },
    addRoute: {
      type: String,
      required: true
    },
    editRoute: {
      type: String,
      required: true
    },
    deleteRoute: {
      type: String,
      required: true
    },
  },

  data () {
    return {
      filteredBills: [...this.bills],
    };
  },

  methods: {
    async deleteBill(id) {

      let isSuccess = false;

      try {

        const response = await axios.delete(`${this.deleteRoute}/${id}`);
        isSuccess= response.data.status;

        // remove the bill
        if (isSuccess) {
          this.filteredBills = this.filteredBills.filter(bill => bill.id !== id);
        }

      } catch (e) {
      }

      const msg = (isSuccess) ? 'সফল ভাবে সম্পন্ন হয়েছে' : 'অজানা কারণে অ্যাকশন সফল হয়নি, দয়াকরে আবার চেষ্টা করুন';
      return confirm (msg);

    },

    sendToEditRoute(id) {
      window.location.href = `${this.editRoute}/${id}`;
    },

    sendToViewRoute(id) {
      window.location.href = `${this.viewRoute}/${id}`;
    },

    isSubmitted(bill) {
      return (bill.status.id === 3); // waiting for approval
    }

  }
}
</script>
