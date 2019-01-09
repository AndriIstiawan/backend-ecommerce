<div class="modal fade" id="blastModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-primary" role="document">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <h4 class="modal-title">Email Blast</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <form  method="POST" action="{{route('mail.store')}}">
            <div class="modal-body">
                {!! csrf_field() !!}
                <input type="hidden" class="id" name="id">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-form-label" for="name">*Admin ID</label>
                            <input type="text" class="form-control" id="adminId" name="adminId" placeholder="adminId" aria-describedby="adminId-error" value="{{Auth::user()->email}}" readonly>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="name">*To</label>
                            <div class="controls form-hide-list">
                            </div>

                            {!! $errors->first('member_id', '<p class="text-danger">:message</p>') !!}
                            
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="name">*Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject" placeholder="subject"
                                aria-describedby="name-error"
                                value="{{ old('subject') ? old('subject') : '' }}" 
                                >
                            {!! $errors->first('subject', '<p class="text-danger">:message</p>') !!}
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="name">*Message</label>
                            <textarea type="text" class="form-control" id="content" name="content" placeholder="content" aria-describedby="content-error">
                                {!! old('content') !!}
                            </textarea>
                            {!! $errors->first('content', '<p class="text-danger">:message</p>') !!}
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="name">*Comment</label>
                            <input type="text" class="form-control" id="comment" name="comment" placeholder="comment" aria-describedby="comment-error" value="{{ old('comment') ? old('comment') : '' }}">

                            {!! $errors->first('comment', '<p class="text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Blast</button>
            </div>
            </form>
        </div>
    </div>
</div>