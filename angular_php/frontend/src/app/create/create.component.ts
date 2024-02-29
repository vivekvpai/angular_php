import { Component } from '@angular/core';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { CommonService } from '../common.service';

@Component({
  selector: 'app-create',
  templateUrl: './create.component.html',
  styleUrls: ['./create.component.css'],
})
export class CreateComponent {
  form: FormGroup = new FormGroup({});

  user_name: any = '';
  password: any = '';

  alert: boolean = false;

  constructor(private common: CommonService) {
    this.form = new FormGroup({
      user_name: new FormControl('', [Validators.required]),
      password: new FormControl('', [Validators.required]),
    });
  }

  submit() {
    if (this.form.invalid) {
      console.log('ERROR');
      this.alert = true;
      this.user_name = '';
      this.password = '';
    } else {
      console.log(this.form.value);
      this.user_name = this.form.value.user_name;
      this.password = this.form.value.password;

      this.common.create_user(this.form.value).subscribe((res) => {
        console.log(res);
      });
    }
  }
}
