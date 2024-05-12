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

