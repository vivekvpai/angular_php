import { Component } from '@angular/core';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { CommonService } from '../common.service';
import { ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-update',
  templateUrl: './update.component.html',
  styleUrls: ['./update.component.css'],
})
export class UpdateComponent {
  form: FormGroup = new FormGroup({});

  alert: boolean = false;

  constructor(private common: CommonService, public actRouter: ActivatedRoute) {
    this.form = new FormGroup({
      user_name: new FormControl('', [Validators.required]),
      password: new FormControl('', [Validators.required]),
    });
  }

  ngOnInit() {
    this.actRouter.queryParams.subscribe((params: any) => {
      this.common.get_user(params.user_name).subscribe((res: any) => {
        console.log(res.data);

        this.form.patchValue(
          {
            user_name: res.data[0].user_name,
            password: res.data[0].user_password
          }
        )

      });
    });
  }

  submit() {
    if (this.form.invalid) {
      console.log('ERROR');
      this.alert = true;
    } else {
      console.log(this.form.value);

      this.common.update_user(this.form.value).subscribe((res) => {
        console.log(res);
      });
    }
  }
}
