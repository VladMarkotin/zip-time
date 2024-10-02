Date.prototype.addDays =
	function (days)
	{
		this.setDate(this.getDate() + days)
		return this
	}
Date.prototype.subtractDays =
	function (days)
	{
		this.setDate(this.getDate() - days)
		return this
	}
Date.prototype.toEnStr =
	function ()
	{
		return this.toISOString().substr(0, 10)
	}
Date.prototype.getCurrentDate = 
	function() 
	{
    	const year = this.getFullYear();
        const month = String(this.getMonth() + 1).padStart(2, '0');
        const day = String(this.getDate()).padStart(2, '0');
        const hours = String(this.getHours()).padStart(2, '0');
        const minutes = String(this.getMinutes()).padStart(2, '0');
        const seconds = String(this.getSeconds()).padStart(2, '0');

        return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
	}
Date.prototype.getTodayFormatedDate = 
	function()
	{
		return this.getCurrentDate().slice(0,10);
	}
Date.prototype.formatDateToDMY =
	function()
	{
		const [year, month, day] = this.getTodayFormatedDate().split('-');
		return `${day}-${month}-${year}`;
	}
