using System;
using System.Collections;
using System.Configuration;
using System.Data;
//using System.Linq;
using System.Web;
using System.Web.Security;
using System.Web.UI;
using System.Web.UI.HtmlControls;
using System.Web.UI.WebControls;
using System.Web.UI.WebControls.WebParts;
//using System.Xml.Linq;
using System.IO;
using System.Text;


public partial class flash_save : System.Web.UI.Page
{

    public static string data = null;
    

    protected void Page_Load(object sender, EventArgs e)
    {
        
        data = Request.Form["save"];
        //data = Request.Params.Get(3).ToString();
        WriteToFile();
                  
    }

    private void WriteToFile()
    {
        //Random random = new Random();
        //Int32 randomNumber = random.Next(0, 99999);
        // string randomStr = randomNumber.ToString(); 
        //string baseURL = Request.Url.Scheme.ToString()+"://"+ Request.Url.Authority + Request.ApplicationPath;
        //string path = Request.PhysicalApplicationPath + "\\download\\circuit"+randomStr+".cir";
        Label1.Text = data;

        //FileStream fStream = File.Create(path);
        //fStream.Close();
        
        try
        {
            //  StreamWriter sWriter = new StreamWriter(path);
            // sWriter.Write(data);
            // sWriter.Close();
            //Response.Redirect(baseURL + "/download/circuit"+randomStr+".cir");
        }
        catch
        {
        
        }



    }


    

}
