<script>
    var gdpData = {"bw":1000,"by":700,"be":158.97,"bb":250,"hb":300, "hh": 600, "he": 200, "mv": 190, "ni":900, "nw": 450, "rp": 600, "sl": 800, "sn": 234, "st": 443, "sh": 345, "th": 342};
    var max = 0,
        min = Number.MAX_VALUE,
        cc,
        startColor = [146, 209, 251],
        endColor = [89, 168, 221],
        colors = {},
        hex;

    //find maximum and minimum values
    for (cc in gdpData)
    {
        if (parseFloat(gdpData[cc]) > max)
        {
            max = parseFloat(gdpData[cc]);
        }
        if (parseFloat(gdpData[cc]) < min)
        {
            min = parseFloat(gdpData[cc]);
        }
    }

    //set colors according to values of GDP
    for (cc in gdpData)
    {
        if (gdpData[cc] > 0)
        {
            colors[cc] = '#';
            for (var i = 0; i<3; i++)
            {
                hex = Math.round(startColor[i]
                    + (endColor[i]
                    - startColor[i])
                    * (gdpData[cc] / (max - min))).toString(16);

                if (hex.length == 1)
                {
                    hex = '0'+hex;
                }

                colors[cc] += (hex.length == 1 ? '0' : '') + hex;
            }
        }
    }

    jQuery('#vmap').vectorMap({
        map: 'germany_en',
        backgroundColor: null,
        hoverColor: '#38a2e9',
        colors: colors
    });
</script>