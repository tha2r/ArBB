        <script type="text/javascript">
        function expandcollapse(group)
        {
          var subnavdiv = document.getElementById('table_'+group);
          var subnavbtn = document.getElementById('button_'+group);

          if(subnavdiv.style.display=='none')
          {
           subnavdiv.style.display='';
           subnavbtn.src='../cpstyles/$cpstyle[dir]/cp_collapse.gif';
            subnavbtn.title='$lang[collapse]';           
           }
           else
           {
            subnavdiv.style.display='none';
            subnavbtn.src='../cpstyles/$cpstyle[dir]/cp_expand.gif';
            subnavbtn.title='$lang[expand]';
            
           }
        }
        </script>
        
        <link href="../cpstyles/$cpstyle[dir]/controlpanel.css" type=text/css rel=stylesheet>
<br>
<div align="center">
<img src="../cpstyles/$cpstyle[dir]/logo.gif">
<br>
$menus
</div>
<br><br>