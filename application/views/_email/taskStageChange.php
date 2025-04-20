<div style="margin:0px auto;max-width:800px;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">

        <tbody>
            <tr>
                <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                    <div
                        style="font-family:Helvetica, Arial, sans-serif;font-size:18px;font-weight:400;line-height:24px;text-align:left;color:#434245;">
                        <table width="100%" border='0' cellpadding='10px' cellspacing='0'>
                            <tbody>
                                <tr>
                                    <th style='width:150px'>TASK</th>
                                    <td><?php echo "{$task->task_number} - {$task->task_name}";?></td>
                                </tr>
                                <tr>
                                    <th>TASK DESCRIPTION</th>
                                    <td><?php echo nl2br($task->task_description);?></td>
                                </tr>
                                <tr>
                                    <th>SECTION</th>
                                    <td><?php echo "{$task->task_section}";?></td>
                                </tr>
                                <tr>
                                    <th>PROJECT NAME</th>
                                    <td><?php echo "{$task->project_name}";?></td>
                                </tr>
                                <tr>
                                    <th>CURRENT STAGE</th>
                                    <td><?php echo strtoupper(str_replace("_"," ",$task->task_stage));?></td>
                                </tr>
                            </tbody>
                        </table>
                </td>
            </tr>

            <tr>
                <td align="left" vertical-align="middle" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                    <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                        style="border-collapse:separate;line-height:100%;">
                        <tbody>
                            <tr>
                                <td align="center" bgcolor="#2e58ff" role="presentation"
                                    style="border:none;border-radius:30px;cursor:auto;mso-padding-alt:10px 25px;background:#2e58ff;"
                                    valign="middle">
                                    <a href="<?php echo base_url($url);?>"
                                        style="display: inline-block; background:rgb(27, 86, 153); color: #ffffff; font-family: Helvetica, Arial, sans-serif; font-size: 14px; font-weight: bold; line-height: 30px; margin: 0; text-decoration: none; text-transform: uppercase; padding: 10px 25px; mso-padding-alt: 0px;;"
                                        target="_blank"> Open Task </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                    <div
                        style="font-family:Helvetica, Arial, sans-serif;font-size:18px;font-weight:400;line-height:24px;text-align:left;color:#434245;">
                        If you need any help, don't hesitate to reach out to us at <a href="#"
                            style="color:rgb(42, 87, 138); text-decoration: none;">info@netsiteweaver.com</a>!
                    </div>
                </td>
            </tr>
            <tr>
                <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                    <div
                        style="font-family:Helvetica, Arial, sans-serif;font-size:18px;font-weight:bold;line-height:24px;text-align:left;color:#434245;">
                        Task Manager</div>
                </td>
            </tr>

        </tbody>

    </table>
</div>