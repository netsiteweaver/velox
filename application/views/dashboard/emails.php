    <div class="row small-text">
        <div class="col-md-12 table-responsive">
            <h4 class='text-center'>Recent Emails Sent</h4>
            <div class="div">
                <table id="latest_logins_table" class="table table-bordered">
                    <thead>
                        <tr class='text-center thead-dark'>
                            <th>Created</th>
                            <th>Customer</th>
                            <th>Domain</th>
                            <th>Subject</th>
                            <th>Recepient</th>
                            <th>Sent</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($latest_emails as $row):?>
                        <tr data-email-id='<?php echo $row->id;?>'>
                            <td><?php echo $row->date_created;?></td>
                            <td><?php echo $row->company_name;?></td>
                            <td><?php echo $row->domain;?></td>
                            <td><?php echo $row->subject;?></td>
                            <td><?php echo $row->recipients;?></td>
                            <td><?php echo $row->date_sent;?></td>
                            <td>
                                <div class="btn btn-default btn-sm view-email"><i class="fa fa-eye"></i> View</div>
                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>  


<!-- Modal -->
<div class="modal fade" id="emailViewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">View Email</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table align='center' style="border:1px solid #000;" cellpadding='10' cellspacing='10'>
            <tbody>
                <tr style='border-bottom:1px solid #ccc;'>
                    <th style='border-right:1px solid #ccc;width:150px;'>Date Created</th>
                    <td class='date_created'></td>
                </tr>
                <tr style='border-bottom:1px solid #ccc;'>
                    <th style='border-right:1px solid #ccc;'>Sender Name</th>
                    <td class='sender_name'></td>
                </tr>
                <tr style='border-bottom:1px solid #ccc;'>
                    <th style='border-right:1px solid #ccc;'>Subject</th>
                    <td class='subject'></td>
                </tr>
                <tr style='border-bottom:1px solid #ccc;'>
                    <th style='border-right:1px solid #ccc;'>Recipients</th>
                    <td class='recipients'></td>
                </tr>
                <tr style='border-bottom:1px solid #ccc;'>
                    <th style='border-right:1px solid #ccc;vertical-align:top;'>Email</th>
                    <td style='padding: 10px;' class='content'></td>
                </tr>
                <tr style='border-bottom:1px solid #ccc;'>
                    <th style='border-right:1px solid #ccc;'>Date Sent</th>
                    <td class='date_sent'></td>
                </tr>
            </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>

