// Simple Receipt class
class Receipt{
    constructor(date, name, amount){
        this.date = date;
        this.name = name;
        this.amount = amount;
    }
}

// Class used to manage receipts
class ReceiptsManager{

    constructor(receipts){
        this.receipts = [];
        receipts = JSON.parse(receipts);
        for(var r in receipts)
        {
            this.receipts.push(new Receipt(moment(receipts[r].date), receipts[r].name, receipts[r].amount));
        }
    }

    // Get receipts ordered by date desc using momentjs
    getRecent()
    {
        return this.receipts.sort(function(a,b){
            var adate = moment(a.date);
            var bdate = moment(b.date);
            if(adate.format('X') > bdate.format('X'))
            {
                return -1;
            }
            return 1;
        })
    }

    // Add a new Receipt
    add(receipt)
    {
        if(this.dateNotExists(receipt.date,-1))
        {
            this.receipts.push(receipt);
            this.save();
            return true;
        }
        return false;

    }

    // Edit a receipt
    edit(id, receipt)
    {
        if(this.dateNotExists(receipt.date, id))
        {
            this.receipts[id] = receipt;
            this.save();
            return true;
        }
        return false;
    }

    // Remove a receipt
    remove(id)
    {
        this.receipts.splice(id, 1);
        this.save();
    }

    // Check if the receipt already exists
    dateNotExists(date, id)
    {
        var date_exists = this.receipts.filter(function(receipt, i){
            return receipt.date.format('YYYY-MM-DD') === date.format('YYYY-MM-DD') && i !== id;
        });

        return date_exists.length === 0;
    }

    // Saving data in the localstorage
    save()
    {
        localStorage.setItem('receipts', JSON.stringify(this.receipts));
    }

    // Find a receipt by its id
    find(id)
    {
        return this.receipts[id];
    }
    // Get total receipts amount
    getTotalByMonth()
    {
        var receipts = this.getRecent();
        var total_month = {};
        for(var r in receipts)
        {
            if(total_month[receipts[r].date.format('MM/YYYY')] === undefined)
            {
                total_month[receipts[r].date.format('MM/YYYY')] = 0;
            }

            total_month[receipts[r].date.format('MM/YYYY')] += this.receipts[r].amount;
        }

        return total_month;
    }
}

