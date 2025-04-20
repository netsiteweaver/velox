<form action="">
<div class="row">
    <?php if ($perms['add']) : ?>
    <div class="col-3 col-sm-3 col-md-1 mt-4">
        <a href="<?php echo base_url("customers/add?referer=customers/listing/".$this->uri->segment(3)); ?>">
            <button type="button" class="btn btn-success btn-block"><i class="fa fa-plus"></i> Add</button>
        </a>
    </div>
    <?php endif; ?>
    <div class="col-3 col-md-2">
        <label for="">Display</label>
        <select class="form-control" name="display" id="rpp">
            <option value="">Select</option>
            <option value="10" <?php echo ( (empty($rows_per_page)) || ($rows_per_page == 10) ) ? 'selected':'';?>>10 rows</option>
            <option value="25" <?php echo ($rows_per_page == 25) ? 'selected':'';?>>25 rows</option>
            <option value="50" <?php echo ($rows_per_page == 50) ? 'selected':'';?>>50 rows</option>
            <option value="100" <?php echo ($rows_per_page == 100) ? 'selected':'';?>>100 rows</option>
        </select>
    </div>
    <div class="col-3 col-sm-3 col-md-2">
        <label for="">Search</label>
        <div class="input-group">
            <input type="search" name="search_text" id="search_text" class="form-control" placeholder="Search Order" value="<?php echo $this->input->get("search_text");?>">
            <div class="input-group-text clear-search cursor-pointer"><i class="fa fa-times"></i></div>
        </div>
    </div>
    <div class="col-3 col-sm-3 col-md-2 mt-4">
        <button class="btn btn-info btn-block"><i class="fa fa-check"></i> Apply</button>
    </div>
</div>
</form>
<?php if( (isset($pagination)) && (!empty($pagination)) ) echo $pagination;?>
<div class="row">
    <div class="col-xs-12 col-sm-12">
        <div class="box">
            <?php if ((isset($customers)) && (!empty($customers))) : ?>
                <div class="box-body table-responsive no-padding">
                    <table id="customers_listing" class="table">
                        <thead>
                            <tr>
                                <th>Company</th>
                                <th>Address</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($customers as $customer) : ?>
                                <tr data-id="<?php echo $customer->uuid; ?>">
                                    <td><?php echo $customer->company_name;?></td>
                                    <td><?php echo $customer->address; ?></td>
                                    <td><?php echo $customer->email; ?></td>
                                    <td>
                                        <?php if ($perms['view']) : ?>
                                        <!-- <a href="<?php echo base_url("customers/view/" . $customer->uuid); ?>"><div class="btn btn-xs btn-flat btn-default"><i class="fa fa-eye"></i> View</div></a> -->
                                        <?php endif;?>
                                        <?php if ($perms['edit']) : ?>
                                            <a href="<?php echo base_url("customers/edit/" . $customer->uuid."?referer=customers/listing/".$this->uri->segment(3,1)); ?>">
                                                <div class="btn btn-md btn-primary"><i class="fa fa-edit"></i></div>
                                            </a>
                                        <?php endif; ?>
                                        <?php if($perms['delete']) echo DeleteButton2('customers','uuid',$customer->uuid,'','','',false); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>

                    </table>
                </div>
            <?php else : ?>
                <p>No records</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php if( (isset($pagination)) && (!empty($pagination)) ) echo $pagination;?>