<template>
  <div class="row">
    <!--list-->
    <div class="col-12">
      <div class="card">
        <div class="card-header card-title-with-btn">
          <div class="card-title-text">ভ্রমণ ভাতা বিলের তালিকা</div>
          <div class="card-title-btns"></div>
        </div>
        <div class="card-body">

          <div class="table-responsive">
            <table class="table table-sm table-bordered">
              <thead>
              <tr>
                <th colspan="3">গমন</th>
                <th colspan="3">আগমন</th>
                <th>ভ্রমণের প্রকৃতি</th>
                <th>শ্রেণী</th>
                <th>ভাড়ার সংখ্যা</th>
                <th>ভাড়ার পরিমান</th>
                <th>ভাতার পরিমান</th>
                <th>দূরত্ব</th>
                <th>মোট ভাড়ার পরিমান</th>
                <th>মোট ভাতার পরিমান</th>
                <th>অ্যাকশন</th>
              </tr>
              <tr>
                <th>গমনের স্থান</th>
                <th>তারিখ</th>
                <th>সময়</th>
                <th>আগমনের স্থান</th>
                <th>তারিখ</th>
                <th>সময়</th>
                <th colspan="9"></th>
              </tr>
              </thead>
              <tbody>
                <tr
                  v-if="dataList.length"
                  v-for="({travelBill, wantId}) in dataList"
                  :key="wantId"
                >
                  <td class="text-center">{{travelBill.fromPlace}}</td>
                  <td class="text-center">{{getFormattedDate(travelBill.fromDate)}}</td>
                  <td class="text-center">{{travelBill.fromTime}}</td>
                  <td class="text-center">{{travelBill.toPlace}}</td>
                  <td class="text-center">{{getFormattedDate(travelBill.toDate)}}</td>
                  <td class="text-center">{{travelBill.toTime}}</td>
                  <td class="text-center">{{travelBill.travelType}}</td>
                  <td class="text-center">{{travelBill.travelExpense.class}}</td>
                  <td class="text-center">{{travelBill.travelExpense.costCount}}</td>
                  <td class="text-center">{{travelBill.travelExpense.costAmount}}</td>
                  <td class="text-center">{{travelBill.travelAllowance.costAmount}}</td>
                  <td class="text-center">{{travelBill.travelAllowance.distance}}</td>
                  <td class="text-center">{{getAllowanceTotal(travelBill)}}</td>
                  <td class="text-center">{{getExpenseTotal(travelBill)}}</td>
                  <td class="text-center close-btn-container">
                    <i
                      v-if="!viewMode"
                      class="fas fa-times close-btn text-danger"
                      @click="removeItem(wantId)"
                    ></i>
                  </td>

                </tr>
                <tr v-if="!dataList.length">
                  <td class="lead text-center" colspan="15">কোনো তথ্য নেই</td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="my-4 text-center">
            <!--<button-->
            <!--  v-if="user.usertype === 'ps'"-->
            <!--  class="btn btn-lg btn-success"-->
            <!--  @click="emitActionEvent('draft')"-->
            <!--&gt;ড্রাফট</button>-->
            <button
              v-if="!viewMode && !isBillSubmitted"
              class="btn btn-lg btn-success"
              @click="emitActionEvent('save')"
            >সংরক্ষণ</button>
            <button
              v-if="!viewMode && !isBillSubmitted"
              class="btn btn-lg btn-warning"
              @click="emitActionEvent('reset')"
            >রিসেট</button>
            <a
              class="btn btn-lg btn-primary"
              :href="mainPageUrl"
            >তালিকায় ফেরত</a>
            <button
              v-if="user.usertype === 'mp' && !isBillSubmitted"
              class="btn btn-lg btn-default"
              @click="emitActionEvent('send')"
            >প্রেরণ</button>
          </div>

        </div>
      </div>
    </div>

  </div>
</template>

<script>
import './TravelAllowanceAddList.scss';
import * as dateFns from 'date-fns';

export default {
  props: {
    isBillSubmitted: {
      type: Boolean,
      default: false
    },
    viewMode: {
      default: false,
    },
    billTypes: {
      type: Array,
      required: true
    },
    dataList: {
      type: Array,
      required: true
    },
    mainPageUrl: {
      type: String,
      required: true
    },
    user: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      data: []
    };
  },

  mounted() {
    this.data = [...this.billTypes];
  },

  watch: {
    // todo: make edit & view
  },

  methods: {
    getBillTypeName(typeId) {

      const type = this.billTypes.find(billType => billType.id === typeId);

      return (type) ? type.name_bn : '';
    },

    getAllowanceTotal(expense) {
      // only calculate for allowance
      if (expense.billType !== 1) {
        return '';
      }

      return expense.travelAllowance.costAmount * expense.travelAllowance.distance;
    },

    getExpenseTotal(expense) {
      // only calculate for expense
      if (expense.billType !== 2) {
        return '';
      }

      return (expense.travelExpense.costCount * expense.travelExpense.costAmount);
    },

    getFormattedDate(date) {
      return dateFns.format(date, 'Y-MM-dd');
    },

    removeItem(wantId) {
      this.$emit('remove-item', wantId);
    },

    emitActionEvent(actionType) {
      this.$emit(`action-fired`, actionType);
    }
  }
}
</script>

<style lang="scss" scoped>
  .close-btn-container {
    display: flex;
    justify-content: center;
    align-items: center;

    .close-btn {
      font-size: 25px;
      cursor: pointer;
    }
  }
</style>
