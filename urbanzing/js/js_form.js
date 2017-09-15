var javascript_form    = {
    data            : null,

    init            : function (config)
    {
        if(this.isArray(config) ||this.isNumeric(config))
            this.data     = config;
        else
            this.data     = eval(config);
    },

    get_opt_value   : function()
    {
        var myOption = -1;
        for (i=(this.data[1]-1); i > -1; i--)
        {
            if (this.data[0][i].checked)
            {
                myOption = i;
                i = -1;
            }
        }
        if(myOption==-1)
            return myOption;
        return this.data[0][myOption].value;
     },
    
    popup_window    : function()
    {
        var url         = (this.data.url)?this.data.url:'';
        var title       = (this.data.title)?this.data.title:'MLM';
        var width       = (this.data.width)?this.data.width:'400';
        var height      = (this.data.height)?this.data.height:'500';
        var menubar     = (this.data.menubar)?this.data.menubar:'no';
        var status      = (this.data.status)?this.data.status:'no';
        var location    = (this.data.location)?this.data.location:'no';
        var toolbar     = (this.data.toolbar)?this.data.toolbar:'no';
        var scrollbars  = (this.data.scrollbars)?this.data.scrollbars:'no';
        window.open(url,title,"width="+width+",height="+height+",menubar="+menubar+",status="+status+",location="+location+",toolbar="+toolbar+",scrollbars="+scrollbars);
    },

    show_element    : function()
    {
        for(i=0; i<this.data.length;i++)
        {
            if(document.getElementById(this.data[i]))
            {
                if(i%2==0)
                    document.getElementById(this.data[i]).style.display='block';
                else
                    document.getElementById(this.data[i]).style.display='none';
            }
       }
    },

    isArray         : function (obj) 
    {
        if (!obj)
            return false;
        try
        {
            if (!(obj.propertyIsEnumerable("length")) && (typeof obj === "object") && (typeof obj.length === "number")) 
            {
                for (var idx in obj) 
                {
                    if (!this.isNumeric(idx))
                        return false;
                }
                return true;
            }
            else
                return false;
        } catch (e)
        {
            return false;
        }
    },

    isNumeric       : function (obj) 
    {
        try
        {
            return (((obj - 0) == obj) && (obj.length > 0));
        } catch (e) {
            return false;
        }
    }

}