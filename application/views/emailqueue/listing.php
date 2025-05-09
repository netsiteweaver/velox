<form id="filters" action="">
    <div class="row">
        <div class="col-md-2">
            <label for="">Customer</label>
            <select name="customer" class="form-control monitor">
                <option value="">Select Customer</option>
                <?php foreach($customers as $row):?>
                <option value="<?php echo $row->company_name;?>" <?php echo ($this->input->get('customer') == $row->company_name) ? 'selected' : ''; ?>><?php echo $row->company_name;?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div class="col-md-2">
            <label for="">Domain</label>
            <select name="domain" class="form-control monitor">
                <option value="">Select Domain</option>
                <?php foreach($domains as $row):?>
                <option value="<?php echo $row->domain;?>" <?php echo ($this->input->get('domain') == $row->domain) ? 'selected' : ''; ?>><?php echo $row->domain;?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div class="col-md-2">
            <label for="">Recipient</label>
            <select name="recipients" class="form-control monitor">
                <option value="">Select Recipient</option>
                <?php foreach($recipients as $row):?>
                <option value="<?php echo $row->recipients;?>" <?php echo ($this->input->get('recipients') == $row->recipients) ? 'selected' : ''; ?>><?php echo $row->recipients;?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div class="col-md-2">
            <label for="">From Date</label>
            <input class="form-control monitor" name="start_date" type="date" value="<?php echo (!empty($this->input->get("start_date"))) ? $this->input->get("start_date") : date("Y-m-d");?>">
        </div>
        <div class="col-md-2">
            <label for="">To Date</label>
            <input class="form-control monitor" name="end_date" type="date" value="<?php echo (!empty($this->input->get("end_date"))) ? $this->input->get("end_date") : date("Y-m-d");?>">
        </div>
        <!-- <div class="form-group mt-4">
            <button class="btn btn-info apply"><i class="fa fa-check"></i> Apply</button>
        </div> -->
    </div>
</form>
<div class="row table-responsive">
    <div class="col-md-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Created</th>
                    <th>Sent <i class="fa fa-sort"></i></th>
                    <th>Delay</th>
                    <th>Customer</th>
                    <th>Domain</th>
                    <th>From Name</th>
                    <th>Subject</th>
                    <th>Recipient</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($emailqueue as $row):?>
                <?php
                $date1 = new DateTime($row->date_created);
                $date2 = new DateTime($row->date_sent);
                $diffInSeconds = abs($date2->getTimestamp() - $date1->getTimestamp());

                if ($diffInSeconds <= 60) {
                    $diff = $diffInSeconds . ' s';
                } elseif($diffInSeconds < 3600) {
                    $diffInMinutes = floor($diffInSeconds / 60);
                    $diff = "<span style='color:orange;'>" . $diffInMinutes . ' m</span>';
                } else {
                    $diffInHours = floor($diffInSeconds / 3600);
                    $diff = "<span style='color:#ff0000;'>" . $diffInHours . ' h</span>';
                }
                ?>
                <tr>
                    <td><?php echo substr($row->uuid,0,8);?></td>
                    <td><?php echo $row->date_created;?></td>
                    <td><?php echo ($row->date_sent == null)?'pending':$row->date_sent;?></td>
                    <td><?php echo $diff;?></td>
                    <td><?php echo $row->company_name;?></td>
                    <td><?php echo $row->domain;?></td>
                    <td><?php echo $row->sender_name;?></td>
                    <td><?php echo $row->subject;?></td>
                    <td><?php echo $row->recipients;?></td>
                    <td>
                        <?php if($perms['view']):?>
                        <a href="<?php echo base_url("emailqueue/view/".$row->uuid."?customer={$this->input->get('customer')}&domain={$this->input->get('domain')}&start_date={$this->input->get('start_date')}&end_date={$this->input->get('end_date')}");?>">
                            <div class="btn btn-default"><i class="fa fa-eye"></i> View</div>
                        </a>
                        <?php endif;?>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <?php echo $pagination;?>
    </div>
</div>