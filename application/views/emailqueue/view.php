<div class="row">
    <div class="col-md-12">
        <table style='border:1px solid #000;' align='center' cellspacing='10' cellpadding='10'>
            <tbody>
                <tr>
                    <th style='border:1px solid #000; width:150px;'>Date Sent</th>
                    <td style='border:1px solid #000; '><?php echo $email->date_sent;?></td>
                </tr>
                <tr>
                    <th style='border:1px solid #000; width:150px;'>Customer</th>
                    <td style='border:1px solid #000; '><?php echo $email->company_name;?></td>
                </tr>
                <tr>
                    <th style='border:1px solid #000; width:150px;'>Subject</th>
                    <td style='border:1px solid #000;'><?php echo $email->subject;?></td>
                </tr>
                <tr>
                    <th style='border:1px solid #000; width:150px;'>Recipients</th>
                    <td style='border:1px solid #000; '><?php echo $email->recipients;?></td>
                </tr>
                <tr>
                    <th style='border:1px solid #000; width:150px; vertical-align:top;'>Email</th>
                    <td><?php echo $email->content;?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="row">
    <div class="col-md-2">
        <a href="<?php echo base_url("emailqueue/listing?customer={$this->input->get('customer')}&domain={$this->input->get('domain')}&start_date={$this->input->get('start_date')}&end_date={$this->input->get('end_date')}");?>">
            <div class="btn btn-warning"><i class="fa fa-chevron-left"></i> Back</div>
        </a>
    </div>
</div>