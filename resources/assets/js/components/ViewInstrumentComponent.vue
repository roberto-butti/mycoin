<template>
  <div>
    <button v-on:click="this.fetchInstrument" class="button is-primary">UPDATE {{ instrument }}</button>
    <table class="table">
      <thead>
        <tr>
          <th>
            <abbr title="ID">ID</abbr>
          </th>
          <th>Created At</th>
          <th>
            <abbr title="Date">Date</abbr>
          </th>
          <th>
            <abbr title="Ask">Ask</abbr>
          </th>
          <th>
            <abbr title="Last">Last - 10%</abbr>
          </th>
          <th>
            <abbr title="Last">Last - 5%</abbr>
          </th>
          <th>
            <abbr title="Last">Last</abbr>
          </th>
          <th>
            <abbr title="Last">Last + 5%</abbr>
          </th>
          <th>
            <abbr title="Last">Last + 10%</abbr>
          </th>

          <th>
            <abbr title="Bid">Bid</abbr>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in this.usertrades">
          <th>{{ item.id }}</th>
          <td>{{ item.created_at }}</td>
          <td>{{ item.date }}</td>

          <td>{{ item.bid }}</td>
          <td>{{ item.last - (item.last * (10/100)) }}</td>
          <td>{{ item.last - (item.last * (5/100)) }}</td>
          <td>
            <b>{{ item.last }}</b>
          </td>
          <td>{{ item.last + (item.last * (5/100)) }}</td>
          <td>{{ item.last + (item.last * (10/100)) }}</td>

          <td>{{ item.ask }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  props: {
    instrument: {
      type: String,
      default: "BTCEUR"
    },
    many: {
      type: String,
      default: "10"
    }
  },
  data() {
    return {
      loading: false,
      usertrades: []
    };
  },
  methods: {
    fetchInstrument() {
      axios
        .get("/api/rock/instrument/" + this.instrument + "/" + this.many)
        .then(response => {
          this.usertrades = response.data;
        });
    }
  },
  mounted() {
    this.fetchInstrument();
  }
};
</script>
